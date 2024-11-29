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
        if (!Schema::hasColumns('app_peserta_has_verifikasiberkas', ['vonis_ukt'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->renameColumn('vonis', 'vonis_ukt');
            });
        }

        if (!Schema::hasColumns('app_peserta_has_verifikasiberkas', ['bayar_ipi'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->renameColumn('bayar_spi', 'bayar_ipi');
            });
        }

        if (!Schema::hasColumns('app_peserta_has_verifikasiberkas', ['nominal_ipi'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->renameColumn('nominal_spi', 'nominal_ipi');
            });
        }

        if (!Schema::hasColumns('app_peserta_has_verifikasiberkas', ['vonis_ipi'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->enum('vonis_ipi', ['k1', 'k2', 'k3', 'k4', 'k5', 'k6', 'k7', 'k8'])->nullable()->after('nominal_ukt');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('app_peserta_has_verifikasiberkas', ['vonis_ipi'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->dropColumn('vonis_ipi');
            });
        }

        if (Schema::hasColumns('app_peserta_has_verifikasiberkas', ['vonis', 'bayar_spi', 'nominal_spi'])) {
            Schema::table('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->renameColumn('vonis_ukt', 'vonis');
                $table->renameColumn('bayar_ipi', 'bayar_spi');
                $table->renameColumn('nominal_ipi', 'nominal_spi');
            });
        }
    }
};
