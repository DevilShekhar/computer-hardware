<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('builder_sub_categories');
        Schema::dropIfExists('builder_categories');
        Schema::dropIfExists('builder_brands');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::create('builder_brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('builder_type_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand_image')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('builder_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('builder_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('cat_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('builder_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('builder_type_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sub_cat_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }
};