<?php

use App\Models\BuilderBrand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('builder_brands', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        BuilderBrand::query()->each(function ($brand) {
            $brand->update([
                'slug' => Str::slug($brand->name) . '-' . $brand->id,
            ]);
        });

        Schema::table('builder_brands', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('builder_brands', function (Blueprint $table) {
            $table->dropUnique('builder_brands_slug_unique');
            $table->dropColumn('slug');
        });
    }
};