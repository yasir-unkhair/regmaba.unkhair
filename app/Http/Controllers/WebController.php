<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\Pesertaukt;
use App\Models\Postingan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    public function index()
    {
        return view('layouts.frontent2');
    }

    public function aktivasi_registrasi($params)
    {
        if (!$params || !data_params($params, 'nomor_peserta')) {
            abort(403);
            exit();
        }

        $peserta = Pesertaukt::where('id', data_params($params, 'id'));
        $get = $peserta->first();
        if ($get->registrasi) {
            abort(403);
            exit();
        }

        $setup = get_setup();
        // dd($setup);
        // jalur SNBP
        if (strtoupper($get->jalur) == 'SNBP') {
            if ($setup && $setup->registrasi_snbp) {
                if (!status_jadwal($setup->registrasi_snbp)) {
                    $ket_registrasi = 'Registrasi Akun Untuk ' . strtoupper($get->jalur) . ' ' . 'Dimulai Tanggal ' . tgl_indo(pecah_jadwal($setup->registrasi_snbp, 0)) . ' s/d ' . tgl_indo(pecah_jadwal($setup->registrasi_snbp, 1));
                    alert()->error('Error', $ket_registrasi);
                    return redirect()->route('auth.login');
                }
            } else {
                $ket_registrasi = 'Registrasi Gagal, Admin Belum Tentukan Tanggal Registrasi ' . strtoupper($get->jalur);
                alert()->error('Error', $ket_registrasi);
                return redirect()->route('auth.login');
            }
        }

        // jalur SNBT
        elseif (strtoupper($get->jalur) == 'SNBT') {
            if ($setup && $setup->registrasi_snbt) {
                if (!status_jadwal($setup->registrasi_snbt)) {
                    $ket_registrasi = 'Registrasi Akun Untuk ' . strtoupper($get->jalur) . ' ' . 'Dimulai Tanggal ' . tgl_indo(pecah_jadwal($setup->registrasi_snbt, 0)) . ' s/d ' . tgl_indo(pecah_jadwal($setup->registrasi_snbt, 1));
                    alert()->error('Error', $ket_registrasi);
                    return redirect()->route('auth.login');
                }
            } else {
                $ket_registrasi = 'Registrasi Gagal, Admin Belum Tentukan Tanggal Registrasi ' . strtoupper($get->jalur);
                alert()->error('Error', $ket_registrasi);
                return redirect()->route('auth.login');;
            }
        }

        // jalur Mandiri
        elseif (strtoupper($get->jalur) == 'MANDIRI') {
            if ($setup && $setup->registrasi_mandiri) {
                if (!status_jadwal($setup->registrasi_mandiri)) {
                    $ket_registrasi = 'Registrasi Akun Untuk Jalur ' . strtoupper($get->jalur) . ' ' . 'Dimulai Tanggal ' . tgl_indo(pecah_jadwal($setup->registrasi_mandiri, 0)) . ' s/d ' . tgl_indo(pecah_jadwal($setup->registrasi_mandiri, 1));
                    alert()->error('Error', $ket_registrasi);
                    return redirect()->route('auth.login');
                }
            } else {
                $ket_registrasi = 'Registrasi Gagal, Admin Belum Tentukan Tanggal Registrasi ' . strtoupper($get->jalur);
                alert()->error('Error', $ket_registrasi);
                return redirect()->route('auth.login');
            }
        }

        $user = User::create([
            'name' => $get->nama_peserta,
            'email' => $get->email,
            'username' => $get->nomor_peserta,
            'password' => Hash::make($get->pass)
        ]);

        // set role user
        $user = User::where('id', $user->id)->first();
        $user->assignRole('peserta');

        $peserta->update([
            'user_id' => $user->id,
            'registrasi' => true,
        ]);

        alert()->success('Success', 'Registrasi sukses, silahkan login dengan akun yang sudah aktif');
        return redirect()->route('auth.login');
    }

    public function lihatdokumen($params)
    {
        if (!$params) {
            abort(404);
            exit();
        }

        $params = decode_arr($params);
        if (!$params) {
            abort(403);
            exit();
        }

        // dd($params);

        $berkas = Berkas::where('id', $params['berkas_id'])->first();
        if ($berkas && in_array(strtolower($berkas->type_berkas), ['jpg', 'jpeg'])) {
            echo "
            <!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link id='favicon' rel='shortcut icon' type='image/x-icon' href='" . asset('images/') . pengaturan('logo') . "' />
                    <title>" . pengaturan('nama-sub-aplikasi') . "</title>
                    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css' integrity='sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M' crossorigin='anonymous'>

                    <style>
                    .avatar {
                        /*    background-color: #7d7d7d;*/
                        border: 2px solid #7d7d7d;
                        padding: 2px;
                    }
                    </style>
                </head>
                <body>
                <div class='container'>
                    <center>
                        <p>
                            <img src='" . $berkas->url_berkas . "' alt='blgo image' class='avatar mt-5'>
                        </p>
                    </center>
                </div>
                </body>
            </html>
            ";
            exit();
        } elseif ($berkas && strtolower($berkas->type_berkas) == 'pdf') {
            echo "
            <!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link id='favicon' rel='shortcut icon' type='image/x-icon' href='" . asset('images/') . pengaturan('logo') . "' />
                    <title>" . pengaturan('nama-sub-aplikasi') . "</title>
                    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css' integrity='sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M' crossorigin='anonymous'>

                    <style>
                    .avatar {
                        /*    background-color: #7d7d7d;*/
                        border: 2px solid #7d7d7d;
                        padding: 2px;
                    }
                    </style>
                </head>
                <body>
                    <center>
                        <iframe src='" . $berkas->url_berkas . "' width='850' height='600'></iframe>
                    </center>
                </body>
            </html>
            ";
            exit();
        } else {
            abort(404);
            exit();
        }
    }
}
