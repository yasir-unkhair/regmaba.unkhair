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
        if (!Schema::hasColumns('app_peserta_has_verifikasiberkas', ['verifies_id'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->foreignId('verifies_id')->nullable()->comment('user yg memverifikasi')->after('rekomendasi')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('app_peserta_has_verifikasiberkas', ['verifies_id'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->dropColumn('verifies_id');
            });
        }
    }
};
