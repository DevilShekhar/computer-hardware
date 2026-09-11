<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_upi_id')->nullable()->after('payment_method');
            $table->string('refund_status')->nullable()->after('customer_upi_id');
            $table->string('refund_method')->nullable()->after('refund_status');
            $table->decimal('refund_amount', 12, 2)->nullable()->after('refund_method');
            $table->string('refund_reason')->nullable()->after('refund_amount');
            $table->text('refund_remark')->nullable()->after('refund_reason');
            $table->timestamp('refunded_at')->nullable()->after('refund_remark');
            $table->string('razorpay_refund_id')->nullable()->after('razorpay_payment_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_upi_id',
                'refund_status',
                'refund_method',
                'refund_amount',
                'refund_reason',
                'refund_remark',
                'refunded_at',
                'razorpay_refund_id',
            ]);
        });
    }
};
