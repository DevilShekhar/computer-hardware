<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->boolean('ship_to_different')->default(false)->after('country');

        $table->string('shipping_name')->nullable()->after('ship_to_different');
        $table->string('shipping_mobile')->nullable()->after('shipping_name');
        $table->string('shipping_address')->nullable()->after('shipping_mobile');
        $table->string('shipping_city')->nullable()->after('shipping_address');
        $table->string('shipping_state')->nullable()->after('shipping_city');
        $table->string('shipping_pincode')->nullable()->after('shipping_state');
        $table->string('shipping_country')->nullable()->after('shipping_pincode');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn([
            'ship_to_different',
            'shipping_name',
            'shipping_mobile',
            'shipping_address',
            'shipping_city',
            'shipping_state',
            'shipping_pincode',
            'shipping_country',
        ]);
    });
}
};
