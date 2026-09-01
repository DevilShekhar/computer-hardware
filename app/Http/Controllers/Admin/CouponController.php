<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display all coupons.
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show create coupon form.
     */
    public function create()
    {
        $products = Product::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.coupons.create', compact('products'));
    }

    /**
     * Store new coupon.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'product_id' => 'nullable|exists:products,id',
            'discount_type' => 'required|in:percentage,flat',
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_value' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'product_id' => $request->product_id,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'minimum_order_value' => $request->minimum_order_value,
            'usage_limit' => $request->usage_limit,
            'used_count' => 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 1,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    /**
     * Show edit coupon form.
     */
    public function edit(Coupon $coupon)
    {
        $products = Product::where('status', 1)
            ->orWhere('id', $coupon->product_id)
            ->orderBy('name')
            ->get();
        return view('admin.coupons.edit', compact('coupon', 'products'));
    }

    /**
     * Update coupon.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,'.$coupon->id,
            'product_id' => 'nullable|exists:products,id',
            'discount_type' => 'required|in:percentage,flat',
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_value' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'product_id' => $request->product_id,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'minimum_order_value' => $request->minimum_order_value,
            'usage_limit' => $request->usage_limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    /**
     * Delete coupon.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->update(['status' => 0]);

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }
}
