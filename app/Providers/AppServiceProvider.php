<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Models\BuilderType;
use App\Models\ProductBrand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Default String Length
        |--------------------------------------------------------------------------
        */

        Schema::defaultStringLength(191);


        /*
        |--------------------------------------------------------------------------
        | Frontend Layout View Composer
        |--------------------------------------------------------------------------
        */

        View::composer('frontend.layouts.app', function ($view) {

            /*
            |--------------------------------------------------------------------------
            | ACTIVE PC BUILDER TYPES
            |--------------------------------------------------------------------------
            */

            $builderTypes = BuilderType::query()
                ->where('status', true)
                ->orderBy('name', 'asc')
                ->get();


            /*
            |--------------------------------------------------------------------------
            | SHOP MENU
            |--------------------------------------------------------------------------
            |
            | Product Brand
            |      |
            |      └── Category
            |              |
            |              └── Sub Category
            |                       |
            |                       └── Product
            |
            |--------------------------------------------------------------------------
            */

            $productBrands = ProductBrand::query()

                /*
                | Active brands only
                */
                ->where('status', true)

                /*
                | Sort brands
                */
                ->orderBy('name', 'asc')

                /*
                | Categories
                */
                ->with([
                    'categories' => function ($categoryQuery) {

                        $categoryQuery

                            /*
                            | Active categories only
                            */
                            ->where('status', true)

                            /*
                            | Sort categories
                            */
                            ->orderBy('name', 'asc')

                            /*
                            | Sub Categories
                            */
                            ->with([
                                'subCategories' => function ($subCategoryQuery) {

                                    $subCategoryQuery

                                        /*
                                        | Active sub categories only
                                        */
                                        ->where('status', true)

                                        /*
                                        | Sort sub categories
                                        */
                                        ->orderBy('name', 'asc')

                                        /*
                                        | Products
                                        */
                                        ->with([
                                            'products' => function ($productQuery) {

                                                /*
                                                | Active products only
                                                */
                                                $productQuery
                                                    ->where('status', true)

                                                    /*
                                                    | Sort products
                                                    */
                                                    ->orderBy('name', 'asc');
                                            }
                                        ]);
                                }
                            ]);
                    }
                ])

                ->get();


            /*
            |--------------------------------------------------------------------------
            | SEND DATA TO FRONTEND LAYOUT
            |--------------------------------------------------------------------------
            */

            $view->with([
                'builderTypes'  => $builderTypes,
                'productBrands' => $productBrands,
            ]);
        });
    }
}