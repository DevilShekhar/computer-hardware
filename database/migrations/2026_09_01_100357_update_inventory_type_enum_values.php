<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE inventories
            MODIFY type VARCHAR(20) NOT NULL DEFAULT 'in'
        ");
        DB::table('inventories')
            ->where('type', 'add')
            ->update(['type' => 'in']);

        DB::table('inventories')
            ->where('type', 'update')
            ->update(['type' => 'in']);

        DB::statement("
            ALTER TABLE inventories
            MODIFY type ENUM('in', 'out') NOT NULL DEFAULT 'in'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE inventories
            MODIFY type VARCHAR(20) NOT NULL DEFAULT 'add'
        ");
        DB::table('inventories')
            ->where('type', 'in')
            ->update(['type' => 'add']);

        DB::table('inventories')
            ->where('type', 'out')
            ->update(['type' => 'add']);
        DB::statement("
            ALTER TABLE inventories
            MODIFY type ENUM('add', 'update') NOT NULL DEFAULT 'add'
        ");
    }
};
