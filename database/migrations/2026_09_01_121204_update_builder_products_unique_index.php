<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('builder_products', function (Blueprint $table) {
            $table->dropUnique('builder_product_unique');

            $table->unique(
                ['builder_type_id', 'product_id', 'builder_sub_category_id'],
                'builder_product_unique'
            );
        });
    }

    public function down()
    {
        Schema::table('builder_products', function (Blueprint $table) {
            $table->dropUnique('builder_product_unique');

            $table->unique(
                ['product_id', 'builder_sub_category_id'],
                'builder_product_unique'
            );
        });
    }
};