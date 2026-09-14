<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pc_builder_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pc_builder_id')->constrained('pc_builders')->cascadeOnDelete();
            $table->unsignedTinyInteger('status');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pc_builder_status_histories');
    }
};
