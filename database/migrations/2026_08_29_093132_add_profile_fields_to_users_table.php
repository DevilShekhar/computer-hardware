<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('gender', 20)->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('gender');
            $table->string('profile')->nullable()->after('birth_date');
            $table->boolean('status')->default(true)->after('profile');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'gender',
                'birth_date',
                'profile',
                'status',
            ]);
        });
    }
};