<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builder_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('builder_brands')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('cat_image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->unique(['brand_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builder_categories');
    }
};