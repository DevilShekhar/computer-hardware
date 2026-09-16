<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('gst_rate', 8, 2)->default(0)->after('quantity');
            $table->decimal('gst_amount', 12, 2)->default(0)->after('gst_rate');

            $table->decimal('cgst_rate', 8, 2)->default(0)->after('gst_amount');
            $table->decimal('cgst_amount', 12, 2)->default(0)->after('cgst_rate');

            $table->decimal('sgst_rate', 8, 2)->default(0)->after('cgst_amount');
            $table->decimal('sgst_amount', 12, 2)->default(0)->after('sgst_rate');

            $table->decimal('igst_rate', 8, 2)->default(0)->after('sgst_amount');
            $table->decimal('igst_amount', 12, 2)->default(0)->after('igst_rate');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'gst_rate',
                'gst_amount',
                'cgst_rate',
                'cgst_amount',
                'sgst_rate',
                'sgst_amount',
                'igst_rate',
                'igst_amount',
            ]);
        });
    }
};
