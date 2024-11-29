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
        Schema::table('app_setup', function (Blueprint $table) {
            $table->boolean('tampil')->default(false)->after('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('app_setup', ['tampil'])) {
            Schema::table('app_setup', function (Blueprint $table) {
                $table->dropColumn('tampil');
            });
        }
    }
};
