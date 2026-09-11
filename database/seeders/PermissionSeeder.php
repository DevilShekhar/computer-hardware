<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            'dashboard-view',

            // Users
            'user-manage',
            'user-create',
            'user-index',
            'user-show',
            'user-edit',
            'user-destroy',

            // Roles
            'roles-manage',
            'roles-create',
            'roles-index',
            'roles-edit',
            'roles-destroy',
            'roles-assign-permission',

            // Orders
            'order-management',
            'order-index',
            'order-show',

            // My Orders
            'my-order-manage',
            'my-order-index',
            'my-order-show',

            // Products
            'product-manage',

            // Brands
            'product-brand-manage',
            'product-brand-index',
            'product-brand-create',
            'product-brand-show',
            'product-brand-edit',
            'product-brand-destroy',

            // Categories
            'product-category-manage',
            'product-category-index',
            'product-category-create',
            'product-category-show',
            'product-category-edit',
            'product-category-destroy',

            // Sub Categories
            'product-sub-category-manage',
            'product-sub-category-index',
            'product-sub-category-create',
            'product-sub-category-show',
            'product-sub-category-edit',
            'product-sub-category-destroy',

            // Products
            'product-index',
            'product-create',
            'product-show',
            'product-edit',
            'product-destroy',
            'product-inventory-history',
            'product-inventory-history-manage',
            // PC Builder Type
            'pc-builder-type-manage',
            'pc-builder-type-index',
            'pc-builder-type-create',
            'pc-builder-type-show',
            'pc-builder-type-edit',
            'pc-builder-type-destroy',

            // PC Builder Product
            'pc-builder-manage',
            'pc-builder-product-manage',
            'pc-builder-product-index',
            'pc-builder-product-create',
            'pc-builder-product-show',
            'pc-builder-product-edit',
            'pc-builder-product-destroy',
            // Product Reviews
            'product-review-manage',
            'product-review-index',
            'product-review-approve',
            'product-review-reject',
            // Coupons
            'coupon-manage',
            'coupon-index',
            'coupon-create',
            'coupon-edit',
            'coupon-show',
            'coupon-destroy',
            // Contact Submissions
            'contact-manage',
            'contact-index',
            // Address Settings
            'address-manage',
            'address-index',
            'address-create',
            'address-edit',
            'address-destroy',
            // GST
            'gst-manage',
            'gst-index',
            'gst-show',
            'gst-edit',
            // Promotional Banners
            'promotional-banner-manage',
            'promotional-banner-index',
            'promotional-banner-create',
            'promotional-banner-show',
            'promotional-banner-edit',
            'promotional-banner-destroy',
            'dashboard-product-count',
            'dashboard-brand-count',
            'dashboard-category-count',
            'dashboard-sub-category-count',
            'dashboard-user-count',
            'dashboard-review-count',
            'dashboard-approved-review-count',
            'dashboard-active-coupon-count',
            'dashboard-expired-coupon-count',

        ];
        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}