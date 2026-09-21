<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ShippingChargeController extends Controller
{
    public function index()
    {
        $shippingCharges = ShippingCharge::latest()->get();

        return view('admin.shipping-charges.index', compact('shippingCharges'));
    }

    public function create()
    {
        return view('admin.shipping-charges.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'state'   => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10|unique:shipping_charges,pincode',
            'charges' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = Auth::id();

        ShippingCharge::create($validated);

        return redirect()
            ->route('shipping-charges.index')
            ->with('success', 'Shipping charge added successfully.');
    }

    public function edit(ShippingCharge $shippingCharge)
    {
        return view('admin.shipping-charges.edit', compact('shippingCharge'));
    }

    public function update(Request $request, ShippingCharge $shippingCharge)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'state'   => 'nullable|string|max:100',
            'city'    => 'nullable|string|max:100',
            'pincode' => ['nullable','string','max:10',
            Rule::unique('shipping_charges', 'pincode')->ignore($shippingCharge->id),
            ],
            'charges' => 'required|numeric|min:0',
        ]);

        $validated['updated_by'] = Auth::id();

        $shippingCharge->update($validated);

        return redirect()
            ->route('shipping-charges.index')
            ->with('success', 'Shipping charge updated successfully.');
    }

    public function destroy(ShippingCharge $shippingCharge)
    {
        $shippingCharge->delete();

        return redirect()
            ->route('shipping-charges.index')
            ->with('success', 'Shipping charge deleted successfully.');
    }
    public function getShippingCharge(Request $request)
    {
        $pincode = trim($request->pincode);

        if (!$pincode ) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a pincode.',
                'charge'  => 0,
            ]);
        }
        $charge = ShippingCharge::where('pincode', $pincode)->first();

        if (!$charge) {
            $charge = ShippingCharge::whereNull('pincode')
                ->first();
        }

        if (!$charge) {
            return response()->json([
                'success'  => true,
                'charge'   => 0,
                'message'  => 'No shipping charge applicable.',
                'free'     => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'charge'  => (float) $charge->charges,
            'name'    => $charge->name,
            'free'    => ((float) $charge->charges <= 0),
        ]);
    }
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $spreadsheet = IOFactory::load($request->file('file')->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) < 2) {
                return redirect()
                    ->route('shipping-charges.index')
                    ->with('error', 'Excel file is empty.');
            }

            $headers = array_map(function ($header) {
                return strtolower(trim($header));
            }, $rows[0]);

            $requiredHeaders = [
                'name',
                'state',
                'city',
                'pincode',
                'charges',
            ];

            foreach ($requiredHeaders as $header) {
                if (!in_array($header, $headers)) {
                    return redirect()
                        ->route('shipping-charges.index')
                        ->with('error', "Missing required column: {$header}");
                }
            }

            $inserted = 0;
            $skipped = 0;
            $errors = [];

            DB::beginTransaction();

            foreach (array_slice($rows, 1) as $index => $row) {
                $rowNumber = $index + 2;

                $data = [];

                foreach ($headers as $key => $header) {
                    $data[$header] = isset($row[$key])
                        ? trim((string) $row[$key])
                        : null;
                }

                // Skip completely empty rows
                if (
                    empty($data['name']) &&
                    empty($data['state']) &&
                    empty($data['city']) &&
                    empty($data['pincode']) &&
                    empty($data['charges'])
                ) {
                    continue;
                }

                // Validate name
                if (empty($data['name'])) {
                    $errors[] = "Row {$rowNumber}: Name is required.";
                    $skipped++;
                    continue;
                }

                // Validate charges
                if ($data['charges'] === null || $data['charges'] === '' || !is_numeric($data['charges'])) {
                    $errors[] = "Row {$rowNumber}: Charges must be numeric.";
                    $skipped++;
                    continue;
                }

                if ((float) $data['charges'] < 0) {
                    $errors[] = "Row {$rowNumber}: Charges cannot be negative.";
                    $skipped++;
                    continue;
                }
                if (!empty($data['pincode'])) {
                    $pincodeExists = ShippingCharge::where('pincode', $data['pincode'])->exists();

                    if ($pincodeExists) {
                        $errors[] = "Row {$rowNumber}: Pincode {$data['pincode']} already exists.";
                        $skipped++;
                        continue;
                    }
                }
                ShippingCharge::create([
                    'name'       => $data['name'],
                    'state'      => $data['state'] ?: null,
                    'city'       => $data['city'] ?: null,
                    'pincode'    => $data['pincode'] ?: null,
                    'charges'    => (float) $data['charges'],
                    'created_by' => Auth::id(),
                ]);

                $inserted++;
            }

            DB::commit();

            $message = "{$inserted} shipping charge(s) uploaded successfully.";

            if ($skipped > 0) {
                $message .= " {$skipped} row(s) skipped.";
            }

            if (!empty($errors)) {
                session()->flash('upload_errors', $errors);
            }

            return redirect()
                ->route('shipping-charges.index')
                ->with('success', $message);

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->route('shipping-charges.index')
                ->with('error', 'Excel upload failed: ' . $e->getMessage());
        }
    }
}
