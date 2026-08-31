<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builder_sub_categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brand_id')
                ->constrained('builder_brands')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained('builder_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name');
            $table->string('slug');

            $table->string('sub_cat_image')->nullable();

            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->boolean('status')->default(1);

            $table->timestamps();

            $table->index(['brand_id', 'category_id']);
            $table->index(['category_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builder_sub_categories');
    }
};