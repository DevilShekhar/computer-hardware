<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('builder_categories', function (Blueprint $table) {
            $table->text('meta_title')->nullable()->after('cat_image');
            $table->text('meta_keywords')->nullable()->after('meta_title');
            $table->text('meta_description')->nullable()->after('meta_keywords');
        });
    }

    public function down(): void
    {
        Schema::table('builder_categories', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_keywords',
                'meta_description',
            ]);
        });
    }
};