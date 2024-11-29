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
        if (!Schema::hasColumns('app_peserta', ['npm', 'tgl_generate'])) {
            Schema::table('app_peserta', function (Blueprint $table) {
                $table->string('npm')->nullable()->after('registrasi');
                $table->dateTime('tgl_generate')->nullable()->after('npm');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('app_peserta', ['npm', 'tgl_generate'])) {
            Schema::table('app_peserta', function (Blueprint $table) {
                $table->dropColumn('npm');
                $table->dropColumn('tgl_generate');
            });
        }
    }
};
