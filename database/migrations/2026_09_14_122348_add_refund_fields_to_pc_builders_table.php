<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pc_builders', function (Blueprint $table) {
            $table->string('razorpay_refund_id')->nullable()->after('razorpay_signature');
            $table->string('refund_status')->nullable()->after('razorpay_refund_id');
            $table->string('refund_method')->nullable()->after('refund_status');
            $table->decimal('refund_amount', 12, 2)->nullable()->after('refund_method');
            $table->string('customer_upi_id')->nullable()->after('refund_amount');
            $table->timestamp('refunded_at')->nullable()->after('customer_upi_id');
        });
    }

    public function down(): void
    {
        Schema::table('pc_builders', function (Blueprint $table) {
            $table->dropColumn([
                'razorpay_refund_id',
                'refund_status',
                'refund_method',
                'refund_amount',
                'customer_upi_id',
                'refunded_at',
            ]);
        });
    }
};
