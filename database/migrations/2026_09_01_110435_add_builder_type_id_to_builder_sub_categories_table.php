<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('builder_sub_categories', function (Blueprint $table) {
            $table->foreignId('builder_type_id')
                ->after('id')
                ->constrained('builder_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('builder_sub_categories', function (Blueprint $table) {
            $table->dropForeign(['builder_type_id']);
            $table->dropColumn('builder_type_id');
        });
    }
};