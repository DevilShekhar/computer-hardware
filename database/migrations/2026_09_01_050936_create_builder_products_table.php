<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builder_products', function (Blueprint $table) {
            $table->id();

            // Main Product
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            // PC Builder Brand
            $table->foreignId('builder_brand_id')
                ->constrained('builder_brands')
                ->cascadeOnDelete();

            // PC Builder Category
            $table->foreignId('builder_category_id')
                ->constrained('builder_categories')
                ->cascadeOnDelete();

            // PC Builder Sub Category
            $table->foreignId('builder_sub_category_id')
                ->constrained('builder_sub_categories')
                ->cascadeOnDelete();

            // Display order
            $table->integer('sort_order')->default(0);

            // Active / Inactive
            $table->boolean('status')->default(true);

            // Created / Updated by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // Prevent duplicate product in same builder sub-category
            $table->unique(
                ['product_id', 'builder_sub_category_id'],
                'builder_product_unique'
            );

            $table->index('builder_brand_id');
            $table->index('builder_category_id');
            $table->index('builder_sub_category_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builder_products');
    }
};