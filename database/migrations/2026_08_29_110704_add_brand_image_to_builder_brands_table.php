<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('builder_brands', function (Blueprint $table) {
            $table->string('brand_image')
                ->nullable()
                ->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('builder_brands', function (Blueprint $table) {
            $table->dropColumn('brand_image');
        });
    }
};