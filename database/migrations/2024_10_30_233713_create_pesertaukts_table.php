<?php

use App\Models\User;
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
        if (!Schema::hasTable('app_peserta')) {
            // Code to create table
            // create table peserta
            Schema::create('app_peserta', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('prodi_id')->nullable()->references('id')->on('app_prodi');
                $table->foreignUuid('fakultas_id')->nullable()->references('id')->on('app_fakultas');
                $table->foreignUuid('setup_id')->nullable()->references('id')->on('app_setup');
                $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
                $table->string('email', 150)->unique()->nullable();
                $table->string('pass', 15)->nullable()->comment('pass ketika registrasi');

                $table->string('nama_peserta', 100)->nullable();
                $table->enum('jk', ['L', 'P'])->nullable();
                $table->string('agama', 25)->nullable();
                $table->string('tpl_lahir', 25)->nullable();
                $table->string('tgl_lahir', 25)->nullable();
                $table->string('nik', 25)->nullable();
                $table->string('thn_lulus', 5)->nullable()->comment('tahun lulus');
                $table->string('jalur', 10)->nullable()->comment('jalur peserta');
                $table->string('jpeserta', 25)->nullable();
                $table->string('nomor_peserta', 60)->unique()->nullable()->comment('nomor peserta dan username login');
                $table->string('nisn', 25)->nullable();
                $table->string('npsn', 25)->nullable();
                $table->string('sekolah_asal', 100)->nullable();
                $table->string('alamat_asal')->nullable();
                $table->string('alamat_tte')->nullable();
                $table->string('hp', 25)->nullable();
                $table->string('hportu', 25)->nullable();
                $table->string('kip', 50)->nullable();
                $table->boolean('update_data_diri')->default(false)->comment('notif update data diri');
                $table->boolean('update_kondisi_keluarga')->default(false)->comment('notif update kondisi keluarga');
                $table->boolean('update_pembiayaan_studi')->default(false)->comment('notif update pembiayaan studi');
                $table->smallInteger('status', FALSE)->nullable()->unsigned()->comment('1 formulir UKT; 2 upload; 3 resume; 4 verifikator; 5 vonis');
                $table->boolean('registrasi')->default(false)->comment('status registrasi akun');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('app_peserta_has_kondisikeluarga')) {
            // create table kondisi_keluarga
            Schema::create('app_peserta_has_kondisikeluarga', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('peserta_id')->nullable()->constrained('app_peserta', 'id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('nama_ayah', 50)->nullable();
                $table->string('nama_ibu', 50)->nullable();
                $table->string('nama_wali',)->nullable();
                $table->uuid('keberadaan_ortu')->nullable()->comment('join referensi');
                $table->smallInteger('jml_kakak', false)->nullable()->unsigned();
                $table->smallInteger('jml_adik', false)->nullable()->unsigned();
                $table->smallInteger('jml_kuliah', false)->nullable()->unsigned();
                $table->smallInteger('jml_sekolah', false)->nullable()->unsigned();
                $table->uuid('pekerjaan_ayah')->nullable()->comment('join referensi');
                $table->string('pangkat_ayah', 50)->nullable();
                $table->string('penghasilan_ayah', 25)->nullable();
                $table->uuid('pekerjaan_ibu')->nullable()->comment('join referensi');
                $table->string('pangkat_ibu', 50)->nullable();
                $table->string('penghasilan_ibu', 25)->nullable();
                $table->string('pebanding_penghasilan_ayah')->nullable();
                $table->string('pebanding_penghasilan_ibu')->nullable();
                $table->uuid('luas_lahan')->nullable()->comment('join referensi');
                $table->json('aset_ortu')->nullable()->comment('data aset format json');
                $table->uuid('kepemilikan_rumah')->nullable()->comment('join referensi');
                $table->uuid('kondisi_rumah')->nullable()->comment('join referensi');
                $table->uuid('lokasi_rumah')->nullable()->comment('join referensi');
                $table->uuid('daya_listrik')->nullable()->comment('join referensi');
                $table->uuid('bantuan_siswa_miskin')->nullable()->comment('join referensi');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('app_peserta_has_pembiayaanstudi')) {
            // create table pembiayaan_studi
            Schema::create('app_peserta_has_pembiayaanstudi', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('peserta_id')->nullable()->constrained('app_peserta', 'id')->onUpdate('cascade')->onDelete('cascade');
                $table->uuid('biaya_studi')->nullable()->comment('join referensi');
                $table->uuid('pekerjaan_sendiri')->nullable()->comment('join referensi');
                $table->string('detail_pekerjaan_sendiri', 100)->nullable()->comment('diisi jika pekerjaan lainnya');
                $table->string('pangkat_sendiri', 50)->nullable();
                $table->uuid('lahan_sendiri')->nullable()->comment('join referensi');
                $table->json('aset_sendiri')->nullable()->comment('data asetsendiri format json');
                $table->string('aset_lainnya', 50)->nullable();
                $table->string('penghasilan_sendiri', 25)->nullable();

                $table->uuid('wali')->nullable()->comment('join referensi');
                $table->uuid('pekerjaan_wali')->nullable()->comment('join referensi');
                $table->string('pangkat_wali', 50)->nullable();
                $table->uuid('lahan_wali')->nullable()->comment('join referensi');
                $table->json('aset_wali')->nullable()->comment('data asetwali format json');
                $table->string('aset_wali_lainnya', 50)->nullable();
                $table->string('penghasilan_wali', 25)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('app_peserta_has_dokumen')) {
            // create table dokumen_peserta
            Schema::create('app_peserta_has_dokumen', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('peserta_id')->nullable()->constrained('app_peserta', 'id')->onUpdate('cascade')->onDelete('cascade');
                $table->smallInteger('urutan', false)->comment('urutan dokumen');
                $table->string('dokumen', 100)->nullable()->comment('nama dokumen');
                $table->foreignUuid('berkas_id')->nullable()->constrained('app_berkas', 'id')->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
            });
        }


        if (!Schema::hasTable('app_peserta_has_verifikasiberkas')) {
            // create table verifikasi_peserta
            Schema::create('app_peserta_has_verifikasiberkas', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('peserta_id')->nullable()->constrained('app_peserta', 'id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('verifikator_id')->nullable()->comment('user verifikator')->references('id')->on('users');
                $table->string('catatan')->nullable()->comment('catatan verifikator');
                $table->enum('rekomendasi', ['wawancara', 'kip-k', 'k1', 'k2', 'k3', 'k4', 'k5', 'k6', 'k7', 'k8'])->nullable()->comment('rekomendasi dari verifikator');
                $table->dateTime('tgl_verifikasi')->nullable()->comment('tgl verivikasi');

                $table->enum('vonis', ['wawancara', 'kip-k', 'k1', 'k2', 'k3', 'k4', 'k5', 'k6', 'k7', 'k8'])->nullable()->comment('status vonis peserta');
                $table->decimal('nominal_ukt', 10, 0)->default(0)->comment('nominal ukt setelah vonis');
                $table->decimal('nominal_spi', 10, 0)->default(0)->comment('nominal spi');
                $table->dateTime('tgl_vonis')->nullable()->comment('tgl vonis ukt');
                $table->foreignId('user_id_vonis')->nullable()->comment('user vonis')->references('id')->on('users');
                $table->boolean('bayar_ukt')->default(false)->comment('status bayar ukt');
                $table->boolean('bayar_spi')->default(false)->comment('status bayar spi');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('app_peserta_has_pembayaran')) {
            // create table pembayaran
            Schema::create('app_peserta_has_pembayaran', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignUuid('peserta_id')->nullable()->constrained('app_peserta', 'id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('jenis_pembayaran', 100)->nullable()->comment('jenis pembayaran');
                $table->text('detail_pembayaran')->nullable()->comment('detail pembayaran');
                $table->string('bank', 50)->nullable();
                $table->string('trx_id', 50)->nullable();
                $table->string('va', 50)->nullable();
                $table->timestamp('expired')->nullable();
                $table->decimal('amount', 10, 0)->nullable();
                $table->boolean('lunas')->default(false);
                $table->timestamp('tgl_pelunasan')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_peserta_has_pembayaran');
        Schema::dropIfExists('app_peserta_has_verifikasiberkas');
        Schema::dropIfExists('app_peserta_has_dokumen');
        Schema::dropIfExists('app_peserta_has_pembiayaanstudi');
        Schema::dropIfExists('app_peserta_has_kondisikeluarga');
        Schema::dropIfExists('app_peserta');
    }
};
