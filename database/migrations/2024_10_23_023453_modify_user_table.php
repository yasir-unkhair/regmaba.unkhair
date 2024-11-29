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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 100)->unique()->nullable()->after('email');
            $table->boolean('user_simak')->default(0)->after('password');
            $table->boolean('is_active')->default(true)->after('user_simak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('users', ['username', 'user_simak', 'is_active'])) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('username');
                $table->dropColumn('user_simak');
                $table->dropColumn('is_active');
            });
        }
    }
};
