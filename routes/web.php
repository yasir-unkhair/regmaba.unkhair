<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(App\Http\Controllers\WebController::class)->group(function () {
    Route::get('/', 'index')->name('frontend.site');
    Route::get('/beranda', 'index')->name('frontend.beranda');
    Route::get('/download', 'download')->name('frontend.download');
    Route::get('/kategoriukt', 'kategoriukt')->name('frontend.kategoriukt');
    Route::get('/kontak', 'kontak')->name('frontend.kontak');

    Route::get('/lihatdokumen/{params}', 'lihatdokumen')->name('frontend.lihatdokumen');

    Route::get('/aktivasi-registrasi/{params}', 'aktivasi_registrasi')->name('registrasi.aktivasi');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/regmaba.unkhair/public/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/regmaba.unkhair/public/livewire/livewire.js', $handle);
});

Route::get('/login', App\Livewire\Auth\Login::class)->name('auth.login');
Route::get('/registrasi', App\Livewire\Auth\Registrasi::class)->name('auth.registrasi');
Route::get('/registrasi/{params}', App\Livewire\Auth\Registrasi::class)->name('auth.registrasi.response');

Route::group(['middleware' => 'isLogin'], function () {

    Route::get('/gantiperan/{role}', [App\Http\Controllers\ChangeRoleController::class, 'index'])->name('change.role');

    Route::controller(App\Http\Controllers\CetakController::class)->group(function () {
        Route::get('/cetak/formverifikator/{params}', 'formverifikator')->name('cetak.formverifikator');
        Route::get('/cetak/formulirukt/{params}', 'formulirukt')->name('cetak.formulirukt');
    });

    // route user admin
    Route::prefix('admin/')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::group(['middleware' => ['role:admin']], function () {
            // route module informasi
            Route::controller(App\Http\Controllers\Admin\DataPesertaController::class)->group(function () {
                Route::get('/peserta/index', 'index')->name('admin.datapeserta.index');
                Route::get('/peserta/upload/{jalur}', 'uploaddata')->name('admin.datapeserta.upload');
                Route::post('/peserta/actupload', 'actuploaddata')->name('admin.datapeserta.actupload');
            });

            Route::controller(App\Http\Controllers\Admin\PesertauktController::class)->group(function () {
                Route::get('/pesertaukt/index', 'index')->name('admin.pesertaukt.index');
            });

            Route::controller(App\Http\Controllers\Admin\PenetapanuktController::class)->group(function () {
                Route::get('/penetapanukt/index', 'index')->name('admin.penetapanukt.index');
                Route::get('/penetapanukt/listdokumen/{params}', 'listdokumen')->name('admin.penetapanukt.listdokumen');
                Route::get('/penetapanukt/laporan', 'laporan')->name('admin.penetapanukt.laporan');
            });

            Route::controller(App\Http\Controllers\Admin\VerifikatorController::class)->group(function () {
                Route::get('/verifikator/index', 'index')->name('admin.verifikator.index');
                Route::get('/verifikator/penugasan', 'penugasan')->name('admin.verifikator.penugasan');
                Route::get('/verifikator/plotting/{params}', 'plotting')->name('admin.verifikator.plotting');
                Route::get('/verifikator/daftarpeserta/{params}', 'daftarpeserta')->name('admin.verifikator.daftarpeserta');
                Route::get('/verifikator/laporan', 'penugasan')->name('admin.verifikator.laporan');
            });

            Route::controller(App\Http\Controllers\Admin\MabaController::class)->group(function () {
                Route::get('/maba/index', 'index')->name('admin.maba.index');
                Route::get('/maba/generatenpm', 'generatenpm')->name('admin.maba.generatenpm');
                Route::get('/maba/generatenpm/{params}', 'generatenpm')->name('admin.maba.generatenpm-params');
                Route::post('/maba/carimaba', 'carimaba')->name('admin.maba.carimaba');
                Route::get('/maba/actgeneratenpm/{params}', 'actgeneratenpm')->name('admin.maba.actgeneratenpm');
            });
        });

        Route::get('/informasi/index', App\Livewire\Postingan\Informasi::class)->name('admin.informasi');
        Route::get('/informasi/add', App\Livewire\Postingan\AddInformasi::class)->name('admin.informasi.add');
        Route::get('/informasi/edit/{id}', App\Livewire\Postingan\EditInformasi::class)->name('admin.informasi.edit');

        //
        Route::get('/fakultas/index', App\Livewire\Master\Fakultas::class)->name('admin.fakultas');

        Route::controller(App\Http\Controllers\Admin\ProdiController::class)->group(function () {
            Route::get('/prodi/index', 'index')->name('admin.prodi.index');
            Route::get('/prodi/biayastudi/{params}', 'biayastudi')->name('admin.prodi.biayastudi');
            // Route::get('/prodi/biayastudi-import', 'import_biayastudi')->name('admin.prodi.importbiayastudi');
        });
        //
        Route::get('/setup/index', App\Livewire\Sistem\Setup::class)->name('admin.setup');
        Route::get('/roles/index', App\Livewire\Sistem\Roles::class)->name('admin.roles');
        Route::get('/pengguna/index', App\Livewire\Sistem\Pengguna::class)->name('admin.pengguna');
        Route::get('/pengguna/import', App\Livewire\Sistem\ImportUserSimak::class)->name('admin.pengguna.import');
        Route::get('/referensi/index', App\Livewire\Sistem\Referensi::class)->name('admin.referensi');
    });

    // route user verifikator
    Route::prefix('verifikator/')->group(function () {
        Route::group(['middleware' => ['role:verifikator']], function () {
            Route::get('/dashboard', [App\Http\Controllers\Verifikator\DashboardController::class, 'index'])->name('verifikator.dashboard');

            Route::controller(App\Http\Controllers\Verifikator\PesertauktController::class)->group(function () {
                Route::get('/pesertaukt/index', 'index')->name('verifikator.pesertaukt.index');
                Route::get('/pesertaukt/listdokumen/{params}', 'listdokumen')->name('verifikator.pesertaukt.listdokumen');
                Route::get('/pesertaukt/laporan', 'laporan')->name('verifikator.pesertaukt.laporan');
            });
        });
    });

    // route user pesertaukt
    Route::prefix('peserta/')->group(function () {
        Route::group(['middleware' => ['role:peserta']], function () {
            Route::controller(App\Http\Controllers\Pesertaukt\DashboardController::class)->group(function () {
                Route::get('/dashboard', 'index')->name('peserta.dashboard');
                Route::get('/resume', 'resume')->name('peserta.resume');
            });

            Route::get('/formulirukt/datadiri', App\Livewire\Pesertaukt\Datadiri::class)->name('peserta.datadiri');
            Route::get('/formulirukt/kondisikeluarga', App\Livewire\Pesertaukt\Kondisikeluarga::class)->name('peserta.kondisikeluarga');
            Route::get('/formulirukt/pembiayaanstudi', App\Livewire\Pesertaukt\Pembiayaanstudi::class)->name('peserta.pembiayaanstudi');

            Route::get('/cetak/formulirukt', [App\Http\Controllers\Pesertaukt\CetakFormuliruktController::class, 'index'])->name('peserta.cetak.formulirukt');
            Route::get('/berkasdukung/index', [App\Http\Controllers\Pesertaukt\UploadBerkasDukungController::class, 'index'])->name('peserta.berkasdukung');
            Route::controller(App\Http\Controllers\Pesertaukt\FinalisasiController::class)->group(function () {
                Route::get('/finalisasi/index', 'index')->name('peserta.finalisasi');
                Route::post('/finalisasi/save', 'save')->name('peserta.finalisasi.save');
            });

            Route::controller(App\Http\Controllers\Pesertaukt\StatusuktController::class)->group(function () {
                Route::get('/statusukt/index', 'index')->name('peserta.statusukt');
                Route::post('/statusukt/ktm', 'ktm')->name('peserta.statusukt.ktm');
            });

            Route::controller(App\Http\Controllers\Pesertaukt\PembayaranController::class)->group(function () {
                Route::get('/pembayaran/index', 'index')->name('peserta.pembayaran');
                Route::get('/pembayaran/detail/{params}', 'detail')->name('peserta.pembayaran.detail');
                Route::get('/pembayaran/cetak/{id}', 'cetak')->name('peserta.pembayaran.cetak');
            });
        });
    });
});
