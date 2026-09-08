<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->foreignId('gst_id')
                ->nullable()
                ->after('hsn')
                ->constrained('gsts')
                ->nullOnDelete();

        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('gst_rate');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropForeign(['gst_id']);
            $table->dropColumn('gst_id');

            $table->decimal('gst_rate', 5, 2)
                ->nullable()
                ->after('hsn');
        });
    }
};