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
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

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
        $latestOrders = collect();
        $latestPendingReviews = collect();
        $monthlyOrders = collect(range(1, 12))->map(function ($month) {
            return [
                'month' => $month,
                'total' => 0,
            ];
        });
        $monthlySales = collect(range(1, 12))->map(function ($month) {
            return [
                'month' => $month,
                'total' => 0,
            ];
        });

        if (auth()->check()) {
            $userId = auth()->id();
            $myOrderCount = Order::where('user_id', $userId)->count();
            $pendingOrderCount = Order::where('user_id', $userId)
                ->where('status', 0)
                ->count();
            $confirmedOrderCount = Order::where('user_id', $userId)
                ->where('status', 1)
                ->count();
            $shippedOrderCount = Order::where('user_id', $userId)
                ->where('status', 3)
                ->count();
            $deliveredOrderCount = Order::where('user_id', $userId)
                ->where('status', 4)
                ->count();
            $cancelledOrderCount = Order::where('user_id', $userId)
                ->where('status', 5)
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
        } else {
            $orderStatus = collect();
        }

        // Status Wise Order Counts
        $orderStatusCounts = [
            0 => Order::where('status', 0)->count(),
            1 => Order::where('status', 1)->count(),
            2 => Order::where('status', 2)->count(),
            3 => Order::where('status', 3)->count(),
            4 => Order::where('status', 4)->count(),
            5 => Order::where('status', 5)->count(),
            6 => Order::where('status', 6)->count(),
            7 => Order::where('status', 7)->count(),
        ];
        $bestSellingProducts = OrderItem::with([
            'product.productBrand',
            'product.images',
        ])
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function ($query) {
                $query->whereNotIn('status', [5, 6]);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(6)
            ->get();

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
            'orderStatus',
            'orderStatusCounts',
            'bestSellingProducts'
        ));
    }

    public function orderStatusCounts()
    {
        return Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('total', 'status');
    }
}
