<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_slug_unique');

            $table->unique(
                ['product_brand_id', 'slug'],
                'categories_brand_slug_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_brand_slug_unique');

            $table->unique('slug', 'categories_slug_unique');
        });
    }
};