<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('builder_brands', function (Blueprint $table) {
            $table->dropUnique('builder_brands_slug_unique');

            $table->unique(
                ['builder_type_id', 'name'],
                'builder_brands_type_name_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('builder_brands', function (Blueprint $table) {
            $table->dropUnique('builder_brands_type_name_unique');

            $table->unique(
                'slug',
                'builder_brands_slug_unique'
            );
        });
    }
};