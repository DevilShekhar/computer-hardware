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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('gst_type')->nullable()->after('discount_amount');
            $table->decimal('gst_amount', 12, 2)->default(0)->after('gst_type');
            $table->decimal('cgst_amount', 12, 2)->default(0)->after('gst_amount');
            $table->decimal('sgst_amount', 12, 2)->default(0)->after('cgst_amount');
            $table->decimal('igst_amount', 12, 2)->default(0)->after('sgst_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'gst_type',
                'gst_amount',
                'cgst_amount',
                'sgst_amount',
                'igst_amount',
            ]);
        });
    }
};
