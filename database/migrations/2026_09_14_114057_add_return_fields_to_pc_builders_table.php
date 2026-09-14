<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pc_builders', function (Blueprint $table) {
            $table->text('return_reason')->nullable()->after('status');
            $table->text('return_remark')->nullable()->after('return_reason');
            $table->timestamp('returned_at')->nullable()->after('return_remark');
        });
    }

    public function down(): void
    {
        Schema::table('pc_builders', function (Blueprint $table) {
            $table->dropColumn([
                'return_reason',
                'return_remark',
                'returned_at',
            ]);
        });
    }
};
