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
        Schema::create('app_setup', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->smallInteger('tahun')->unique()->unsigned()->comment('tahun penerimaan');

            $table->string('registrasi_snbp', 60)->nullable()->comment('tanggal registrasi akun');
            $table->string('pengisian_snbp', 60)->nullable()->comment('tanggal pengisian/upload dokumen data UK');
            $table->string('pembayaran_snbp', 60)->nullable();

            $table->string('registrasi_snbt', 60)->nullable()->comment('tanggal registrasi akun');
            $table->string('pengisian_snbt', 60)->nullable()->comment('tanggal pengisian/upload dokumen data UK');
            $table->string('pembayaran_snbt', 60)->nullable();

            $table->string('registrasi_mandiri', 60)->nullable()->comment('tanggal registrasi akun');
            $table->string('pengisian_mandiri', 60)->nullable()->comment('tanggal pengisian/upload dokumen data UK');
            $table->string('pembayaran_mandiri', 60)->nullable();

            $table->enum('aktif', ['Y', 'N'])->default('N');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_setup');
    }
};
