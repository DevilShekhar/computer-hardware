<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Review;
use App\Models\Coupon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Basic Counts
        $productCount = Product::count();
        $brandCount = ProductBrand::count();
        $categoryCount = Category::count();
        $subCategoryCount = SubCategory::count();
        $userCount = User::count();

        // Review Counts
        $reviewCount = Review::count();
        $approvedReviewCount = Review::where('status', true)->count();

        // Coupon Counts
        $activeCouponCount = Coupon::where('status', true)
            ->whereDate('end_date', '>=', now()->toDateString())
            ->count();

        $expiredCouponCount = Coupon::whereDate('end_date', '<', now()->toDateString())
            ->count();

        return view('admin.dashboard', compact(
            'productCount',
            'brandCount',
            'categoryCount',
            'subCategoryCount',
            'userCount',
            'reviewCount',
            'approvedReviewCount',
            'activeCouponCount',
            'expiredCouponCount'
        ));
    }
}