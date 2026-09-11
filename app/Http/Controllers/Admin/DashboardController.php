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
use App\Models\Order;

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
        // My Orders Count - Logged In User Only
        $myOrderCount = 0;
        $pendingOrderCount = 0;
        $confirmedOrderCount = 0;
        $shippedOrderCount = 0;
        $deliveredOrderCount = 0;
        $cancelledOrderCount = 0;
        if (auth()->check()) {
            $userId = auth()->id();
            $myOrderCount = Order::where('user_id', $userId)->count();
            $pendingOrderCount = Order::where('user_id', $userId)
                ->where('status', 'pending')
                ->count();
            $confirmedOrderCount = Order::where('user_id', $userId)
                ->where('status', 'confirmed')
                ->count();
            $shippedOrderCount = Order::where('user_id', $userId)
                ->where('status', 'shipped')
                ->count();
            $deliveredOrderCount = Order::where('user_id', $userId)
                ->where('status', 'delivered')
                ->count();
            $cancelledOrderCount = Order::where('user_id', $userId)
                ->where('status', 'cancelled')
                ->count();
            $latestOrders = Order::with('user')
                ->latest()
                ->take(5)
                ->get();
            $latestPendingReviews = Review::with(['product.images', 'user'])
                ->where('status', 0)
                ->latest('created_at')
                ->take(10)
                ->get();
            $monthlyOrdersData = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            $monthlySalesData = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
                ->whereYear('created_at', now()->year)
                ->where('status', '!=', 5)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            $monthlyOrders = collect(range(1, 12))->map(function ($month) use ($monthlyOrdersData) {
                return [
                    'month' => $month,
                    'total' => (int) ($monthlyOrdersData[$month] ?? 0),
                ];
            });

            $monthlySales = collect(range(1, 12))->map(function ($month) use ($monthlySalesData) {
                return [
                    'month' => $month,
                    'total' => (float) ($monthlySalesData[$month] ?? 0),
                ];
            });

            $orderStatus = Order::selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->orderBy('status')
                ->get();
        }

        return view('admin.dashboard', compact(
            'productCount',
            'brandCount',
            'categoryCount',
            'subCategoryCount',
            'userCount',
            'reviewCount',
            'approvedReviewCount',
            'activeCouponCount',
            'expiredCouponCount',
            'myOrderCount',
            'pendingOrderCount',
            'confirmedOrderCount',
            'shippedOrderCount',
            'deliveredOrderCount',
            'cancelledOrderCount',
            'latestOrders',
            'latestPendingReviews',
            'monthlyOrders',
            'monthlySales',
            'orderStatus'
        ));
    }
}