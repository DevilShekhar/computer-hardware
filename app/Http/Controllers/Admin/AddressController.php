<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('admin.addresses.index', compact('addresses'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('admin.addresses.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_type' => 'required|in:home,office,other',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $isDefault = $request->boolean('is_default');
            if ($isDefault || !Address::where('user_id', $user->id)->exists()) {
                Address::where('user_id', $user->id)
                    ->update(['is_default' => false]);
                $isDefault = true;
            }
            Address::create([
                'user_id' => $user->id,
                'address_type' => $request->address_type,
                'name' => $user->name,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country ?: 'India',
                'pincode' => $request->pincode,
                'is_default' => $isDefault,
            ]);
        });
        return redirect()
            ->route('addresses.index')
            ->with('success', 'Address added successfully.');
    }
    public function edit(Address $address)
    {
        $this->checkOwnership($address);
        $user = Auth::user();
        return view('admin.addresses.edit', compact('address', 'user'));
    }

    public function update(Request $request, Address $address)
    {
        $this->checkOwnership($address);
        $request->validate([
            'address_type' => 'required|in:home,office,other',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);
        $user = Auth::user();
        DB::transaction(function () use ($request, $address, $user) {
            $isDefault = $request->boolean('is_default');
            if ($isDefault) {
                Address::where('user_id', $user->id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
            $address->update([
                'address_type' => $request->address_type,
                'name' => $user->name,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country ?: 'India',
                'pincode' => $request->pincode,
                'is_default' => $isDefault,
            ]);
        });

        return redirect()
            ->route('addresses.index')
            ->with('success', 'Address updated successfully.');
    }
    public function destroy(Address $address)
    {
        $this->checkOwnership($address);
        $wasDefault = $address->is_default;
        $userId = $address->user_id;
        $address->delete();
        if ($wasDefault) {
            $newDefault = Address::where('user_id', $userId)
                ->latest()
                ->first();

            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }
        return redirect()
            ->route('addresses.index')
            ->with('success', 'Address deleted successfully.');
    }

    private function checkOwnership(Address $address)
    {
        abort_unless($address->user_id === Auth::id(), 403);
    }
}
