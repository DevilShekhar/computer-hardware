<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuilderProduct;
use App\Models\BuilderType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuilderProductController extends Controller
{
    public function index(Request $request)
    {
        $query = BuilderProduct::with(['product','builderType','createdBy','updatedBy',]);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('builder_type_id')) {
            $query->where(
                'builder_type_id',
                $request->builder_type_id
            );
        }
        if ($request->filled('product_type')) {
            $query->where(
                'product_type',
                $request->product_type
            );
        }
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }
        $builderProducts = $query->orderBy('sort_order')->latest()->paginate(20)->withQueryString();
        $builderTypes = BuilderType::orderBy('name')->get();
        $productTypes = ['Processor','Motherboard','RAM','Graphics Card','Storage','Power Supply','Cabinet','CPU Cooler',];
        return view('admin.builder-products.index',compact('builderProducts','builderTypes','productTypes'));
    }
    public function create()
    {
        $products = Product::where('status', true)->orderBy('name')->get();
        $builderTypes = BuilderType::where('status', true)->orderBy('name')->get();
        $productTypes = [
            'Processor',
            'Motherboard',
            'RAM',
            'Graphics Card',
            'Storage',
            'Power Supply',
            'Cabinet',
            'CPU Cooler',
        ];
        return view('admin.builder-products.create',compact('products','builderTypes','productTypes'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'builder_type_id' => ['required','exists:builder_types,id',],
                'product_type' => ['required','string','max:255',],
                'product_id' => ['required','exists:products,id',],
                'sort_order' => ['nullable','integer','min:0',],
            ],
            [
                'builder_type_id.required' =>'PC Builder Type is required.',
                'builder_type_id.exists' =>'Selected PC Builder Type does not exist.',
                'product_type.required' =>'Product Type is required.',
                'product_type.string' =>'Product Type must be a valid text value.',
                'product_type.max' =>'Product Type cannot exceed 255 characters.',
                'product_id.required' =>'Product is required.',
                'product_id.exists' =>'Selected product does not exist.',
                'sort_order.integer' =>'Sort order must be a number.',
                'sort_order.min' =>'Sort order cannot be negative.',
            ]
        );
        $exists = BuilderProduct::where('builder_type_id',$validated['builder_type_id'])
            ->where('product_type',$validated['product_type'])
            ->where('product_id',$validated['product_id'])
            ->exists();
        if ($exists) {
            return back()->withInput()->withErrors([
                'product_id' =>'This product is already assigned to this PC Builder Type and Product Type.',]);
        }
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['status'] = 1;
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        BuilderProduct::create($validated);
        return redirect()->route('builder-products.index')->with('success','Product added to PC Builder successfully.');
    }
    public function show(BuilderProduct $builderProduct)
    {
        $builderProduct->load([
            'product',
            'builderType',
            'createdBy',
            'updatedBy',
        ]);
        return view('admin.builder-products.show',compact('builderProduct'));
    }
    public function edit(BuilderProduct $builderProduct)
    {
        $products = Product::where(function ($query) use ($builderProduct) {
            $query->where('status', true)->orWhere('id',$builderProduct->product_id);
        })->orderBy('name')->get();
        $builderTypes = BuilderType::where(function ($query) use ($builderProduct) {
            $query->where('status', true)->orWhere('id',$builderProduct->builder_type_id);
        })->orderBy('name')->get();
        $productTypes = [
            'Processor',
            'Motherboard',
            'RAM',
            'Graphics Card',
            'Storage',
            'Power Supply',
            'Cabinet',
            'CPU Cooler',
        ];
        if ($builderProduct->product_type && !in_array($builderProduct->product_type, $productTypes)) {
            $productTypes[] = $builderProduct->product_type;
        }
        return view('admin.builder-products.edit',compact('builderProduct','products','builderTypes','productTypes'));
    }
    public function update(Request $request,BuilderProduct $builderProduct) {
        $validated = $request->validate(
            [
                'builder_type_id' => ['required','exists:builder_types,id',],
                'product_type' => ['required','string','max:255',],
                'product_id' => ['required','exists:products,id',],
                'sort_order' => ['nullable','integer','min:0',],
                'status' => ['required','boolean',],
            ],
            [
                'builder_type_id.required' =>'PC Builder Type is required.',
                'builder_type_id.exists' =>'Selected PC Builder Type does not exist.',
                'product_type.required' =>'Product Type is required.',
                'product_type.string' =>'Product Type must be a valid text value.',
                'product_type.max' =>'Product Type cannot exceed 255 characters.',
                'product_id.required' =>'Product is required.',
                'product_id.exists' =>'Selected product does not exist.',
                'sort_order.integer' =>'Sort order must be a number.',
                'sort_order.min' =>'Sort order cannot be negative.',
                'status.required' =>'Status is required.',
            ]
        );
        $exists = BuilderProduct::where('builder_type_id',$validated['builder_type_id'])
            ->where('product_type',$validated['product_type'])
            ->where('product_id',$validated['product_id'])
            ->where('id','!=',$builderProduct->id)
            ->exists();
        if ($exists) {
            return back()->withInput()->withErrors([
                'product_id' =>
                    'This product is already assigned to this PC Builder Type and Product Type.',
            ]);
        }
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['status'] = $request->boolean('status');
        $validated['updated_by'] =  Auth::id();
        $builderProduct->update($validated);
        return redirect()
            ->route('builder-products.index')
            ->with(
                'success',
                'PC Builder product updated successfully.'
            );
    }
    public function destroy(BuilderProduct $builderProduct)
    {
        $builderProduct->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);
        return redirect()
            ->route('builder-products.index')
            ->with(
                'success',
                'Builder product deactivated successfully.'
            );
    }
}