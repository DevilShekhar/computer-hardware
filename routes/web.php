<?php

use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\BuilderProductController;
use App\Http\Controllers\Admin\BuilderTypeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PromotionalBannerController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OurProductController;
use App\Http\Controllers\Frontend\PcBuilderController;
use App\Http\Controllers\Frontend\OurBrandController;
use App\Http\Controllers\Frontend\AboutUsController;
use App\Http\Controllers\Frontend\PrivacyPolicyController;
use App\Http\Controllers\Frontend\TermsAndConditionController;
use App\Http\Controllers\Frontend\DisclaimerController;
use App\Http\Controllers\Frontend\SiteMapController;
use App\Http\Controllers\Frontend\OurCategoryController;
use App\Http\Controllers\Frontend\OurSubCategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\GstController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-change-password', [ProfileController::class, 'changePassword'])->name('password.index');
    Route::post('/my-change-password/verify', [ProfileController::class, 'verifyOldPassword'])->name('password.verify');
    Route::get('/my-change-password/new', [ProfileController::class, 'newPassword'])->name('password.new');
    Route::post('/my-change-password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/permissions-data', [RoleController::class, 'getPermissionsData'])->name('roles.permissions.data');
    Route::get('roles/{role}/permissions', [RoleController::class, 'managePermissions'])->name('roles.permissions');
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->names('admin.users');

    Route::resource('builder-types', BuilderTypeController::class);
    Route::resource('builder-products', BuilderProductController::class);

    Route::resource('product-brands', ProductBrandController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('sub-categories/categories-by-brand/{brand}', [SubCategoryController::class, 'getCategoriesByBrand'])->name('sub-categories.categories-by-brand');
    Route::resource('sub-categories', SubCategoryController::class);

    Route::delete('products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::get('/products/inventory-history', [ProductController::class, 'inventoryHistory'])->name('products.inventory-history');
    Route::get('/products/inventory-history-data/{product?}', [ProductController::class, 'inventoryHistoryData'])->name('products.inventory-history.data');
    Route::get('/products/stock/{type?}', [ProductController::class, 'stockProducts'])->name('products.stock');
    Route::resource('products', ProductController::class);
    Route::get('products/categories-by-brand/{brand}', [ProductController::class, 'getCategoriesByBrand'])->name('products.categories-by-brand');
    Route::get('products/sub-categories-by-category/{category}', [ProductController::class, 'getSubCategoriesByCategory'])->name('products.sub-categories-by-category');

    Route::resource('coupons', CouponController::class)->names('coupons');

    Route::post('/products/{product}/add-stock', [ProductController::class, 'addStock'])->name('products.add-stock');

    Route::resource('promotional-banners', PromotionalBannerController::class);
    Route::patch('promotional-banners/{promotionalBanner}/activate', [PromotionalBannerController::class, 'activate'])->name('promotional-banners.activate');

    Route::get('/product-review', [ProductReviewController::class, 'index'])->name('product-review.index');
    Route::post('/product-review/{review}/approve', [ProductReviewController::class, 'approve'])->name('product-review.approve');
    Route::post('/product-review/{review}/reject', [ProductReviewController::class, 'reject'])->name('product-review.reject');
    Route::get('/contact-submissions',[ContactSubmissionController::class, 'index'])->name('admin.contact-submissions.index');
    Route::resource('gsts', GstController::class);
    Route::get('/customer-orders', [OrderManagementController::class, 'index'])->name('customer-orders.index');
    Route::get('/customer-orders/{order}', [OrderManagementController::class, 'show'])->name('customer-orders.show');
    Route::post('/customer-orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('customer-orders.update-status');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/our-products', [OurProductController::class, 'index'])->name('our-products');
Route::get('/discounted-products', [OurProductController::class, 'discountedProducts'])->name('our-products.discounted');
Route::get('/our-product/{slug}', [OurProductController::class, 'show'])->name('product.details');

Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

Route::get('/login-for-review/{slug}', function ($slug) {
    session(['url.intended' => route('product.details', ['slug' => $slug]) . '?review=1']);
    return redirect()->route('login');
})->name('login.for.review');

Route::get('/compare', [OurProductController::class, 'compare'])->name('compare');
Route::get('/compare/products', [OurProductController::class, 'compareProducts'])->name('compare.products');

Route::get('/pc-builder', [PcBuilderController::class, 'index'])->name('pc-builder.index');
Route::get('/pc-builder/{slug}', [PcBuilderController::class, 'show'])->name('pc-builder.show');
Route::get('/our-brand', [OurBrandController::class, 'index'])->name('our-brand');
Route::get('/our-brand/{slug}', [OurBrandController::class, 'show'])->name('our-brand.show');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');
Route::get('/terms-and-conditions', [TermsAndConditionController::class, 'index'])->name('terms-and-conditions');
Route::get('/disclaimer', [DisclaimerController::class, 'index'])->name('disclaimer');
Route::get('/sitemap.xml', [SiteMapController::class, 'index'])->name('sitemap');
Route::get('/our-category', [OurCategoryController::class, 'index'])->name('our-category');
Route::get('/our-category/{slug}', [OurCategoryController::class, 'show'])->name('our-category.show');
Route::get('/wishlist', function () {
    return view('frontend.wishlist');
})->name('wishlist');
Route::get('/our-sub-category', [OurSubCategoryController::class, 'index'])->name('our-sub-category');
Route::get('/our-sub-category/{slug}', [OurSubCategoryController::class, 'show'])->name('our-sub-category.show');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact-us/thank-you', [ContactController::class, 'thankYou'])->name('contact.thank-you');
Route::get('/product-search', [OurProductController::class, 'search'])->name('frontend.product.search');
//CartControllerfr
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/mini', [CartController::class, 'miniCart'])->name('cart.mini');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/place-order', [CartController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/checkout/apply-coupon',[OrderController::class,'applyCoupon'])->name('checkout.apply-coupon');
    Route::resource('addresses', AddressController::class);
    Route::post('/razorpay/verify', [OrderController::class, 'verifyRazorpayPayment'])->name('razorpay.verify');
});
Route::post('/checkout/update-quantity', [OrderController::class, 'updateQuantity'])->name('checkout.update-quantity');
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
