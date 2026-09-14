<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pc_builders', function (Blueprint $table) {
            $table->string('cancel_reason', 255)->nullable()->after('status');
            $table->text('cancel_remark')->nullable()->after('cancel_reason');
            $table->timestamp('cancelled_at')->nullable()->after('cancel_remark');
        });
    }

    public function down(): void
    {
        Schema::table('pc_builders', function (Blueprint $table) {
            $table->dropColumn([
                'cancel_reason',
                'cancel_remark',
                'cancelled_at',
            ]);
        });
    }
};
