<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'user'])->latest()->paginate(20);
        return view('admin.product-review.index', compact('reviews'));
    }
    public function approve(Review $review)
    {
        $review->update([
            'status' => 1,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Review approved successfully.');
    }
    public function reject(Review $review)
    {
        $review->update([
            'status' => 0,
            'approved_by' => null,
            'approved_at' => null,
        ]);
        return redirect()->back()->with('success', 'Review rejected successfully.');
    }
}