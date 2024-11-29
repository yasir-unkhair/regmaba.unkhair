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
        Schema::table('app_peserta', function (Blueprint $table) {
            $table->uuid('golongan_darah')->nullable()->after('jk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('app_peserta', ['golongan_darah'])) {
            Schema::table('app_peserta', function (Blueprint $table) {
                $table->dropColumn('golongan_darah');
            });
        }
    }
};
