<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\BuilderType;
use App\Models\ProductBrand;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('frontend.layouts.app', function ($view) {
            $builderTypes = BuilderType::query()
                ->where('status', true)
                ->orderBy('name', 'asc')
                ->get();

            $productBrands = ProductBrand::query()
                ->where('status', true)
                ->orderBy('name', 'asc')
                ->with([
                    'categories' => function ($categoryQuery) {
                        $categoryQuery
                            ->where('status', true)
                            ->orderBy('name', 'asc')
                            ->with([
                                'subCategories' => function ($subCategoryQuery) {
                                    $subCategoryQuery
                                        ->where('status', true)
                                        ->orderBy('name', 'asc')
                                        ->with([
                                            'products' => function ($productQuery) {
                                                $productQuery
                                                    ->where('status', true)
                                                    ->orderBy('name', 'asc');
                                            }
                                        ]);
                                }
                            ]);
                    }
                ])
                ->get();

            $view->with([
                'builderTypes' => $builderTypes,
                'productBrands' => $productBrands,
            ]);
        });
    }
}