<?php

namespace App\Livewire\Auth;

use App\Jobs\SendMail;
use App\Mail\RegisterMail;
use App\Models\Pesertaukt;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Registrasi extends Component
{
    public $currentStep = 1;

    public $peserta_id;

    public $nomor_peserta;
    public $nisn;
    public $email;

    public $get = NULL;

    public function mount($params = NULL)
    {
        if ($params && data_params($params, 'nomor_peserta')) {
            $this->get = decode_arr($params);
            $this->currentStep = 2;
        }
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function render()
    {
        $data = [
            'judul' => 'Registrasi Akun'
        ];
        return view('livewire.auth.registrasi', $data)
            ->extends('layouts.auth')
            ->section('content');
    }

    public function check()
    {
        $this->validate(
            [
                'nomor_peserta' => ['required', 'exists:app_peserta,nomor_peserta'],
                'nisn' => ['required', 'exists:app_peserta,nisn']
            ],
            [
                'nomor_peserta.required' => 'Kolom Nomor Peserta jangan dikosongkan!',
                'nomor_peserta.exists' => 'Nomor Peserta ' . $this->nomor_peserta . ' tidak ditemukan!',

                'nisn.required' => 'Kolom NISN jangan dikosongkan!',
                'nisn.exists' => 'NISN ' . $this->nisn . ' tidak ditemukan!',
            ]
        );

        $cekdata = Pesertaukt::with(['prodi'])->where('nomor_peserta', $this->nomor_peserta)->where('nisn', $this->nisn)->first();
        // dd($cekdata);
        if (!$cekdata) {
            // flash('error', 'Kombinasi Nomor Peserta ' . $this->nomor_peserta . ' dan NISN ' . $this->nisn . ' tidak valid!');
            $this->dispatch('alert', type: 'error', message: 'Kombinasi Nomor Peserta ' . $this->nomor_peserta . ' dan NISN ' . $this->nisn . ' tidak ditemukan!');
        } else {

            /**
             * menangani peserta utk tidak melakukan pergantian email resgitrasi secara ualang2 krn email registrasi belum masuk.
             * peserta dapat mengganti email registrasi jika:
             * 1. belum melakukan aktivasi akun
             * 2. menunggu beberapa menit agar dapat mengganti email, disini sistem mengijinkan 10 menit dari registrasi awal 
             */

            if ($cekdata->registrasi) {
                // flash('error', 'Nomor Peserta ' . $this->nomor_peserta . ' sudah melakukan registrasi!');
                // alert()->success('Success', 'Pengguna SIMAK berhasil ditambahkan.');
                $this->dispatch('alert', type: 'error', message: 'Nomor Peserta ' . $this->nomor_peserta . ' sudah melakukan registrasi!');
            } else {
                $err = 0;
                if ($cekdata->email) {
                    $jam_registrasi = Carbon::parse($cekdata->updated_at);
                    $jam_sekarang = Carbon::parse(now()->format('Y-m-d H:i:s'));
                    $total_waktu = $jam_sekarang->diff($jam_registrasi);
                    $total_hari = $total_waktu->d;
                    $total_jam = $total_waktu->h;
                    $total_menit = $total_waktu->i;

                    if (($total_hari == 0) && ($total_jam == 0) && ($total_menit < 10)) {
                        $this->dispatch('alert', type: 'error', message: 'Tunggu beberapa saat lagi untuk mengganti/mengirim kembali E-Mail Konfirmasi!');
                        $err++;
                    }
                }

                $setup = get_setup();
                // dd($setup);
                // jalur SNBP
                if (strtoupper($cekdata->jalur) == 'SNBP') {
                    if ($setup && $setup->registrasi_snbp) {
                        if (!status_jadwal($setup->registrasi_snbp)) {
                            $ket_registrasi = 'Registrasi Akun Untuk ' . strtoupper($cekdata->jalur) . ' ' . 'Dimulai Tanggal ' . tgl_indo(pecah_jadwal($setup->registrasi_snbp, 0)) . ' s/d ' . tgl_indo(pecah_jadwal($setup->registrasi_snbp, 1));
                            $this->dispatch('alert', type: 'error', message: $ket_registrasi);
                            $err++;
                        }
                    } else {
                        $ket_registrasi = 'Registrasi Gagal, Admin Belum Tentukan Tanggal Registrasi ' . strtoupper($cekdata->jalur);
                        $this->dispatch('alert', type: 'error', message: $ket_registrasi);
                        $err++;
                    }
                }

                // jalur SNBT
                elseif (strtoupper($cekdata->jalur) == 'SNBT') {
                    if ($setup && $setup->registrasi_snbt) {
                        if (!status_jadwal($setup->registrasi_snbt)) {
                            $ket_registrasi = 'Registrasi Akun Untuk ' . strtoupper($cekdata->jalur) . ' ' . 'Dimulai Tanggal ' . tgl_indo(pecah_jadwal($setup->registrasi_snbt, 0)) . ' s/d ' . tgl_indo(pecah_jadwal($setup->registrasi_snbt, 1));
                            $this->dispatch('alert', type: 'error', message: $ket_registrasi);
                            $err++;
                        }
                    } else {
                        $ket_registrasi = 'Registrasi Gagal, Admin Belum Tentukan Tanggal Registrasi ' . strtoupper($cekdata->jalur);
                        $this->dispatch('alert', type: 'error', message: $ket_registrasi);
                        $err++;
                    }
                }

                // jalur Mandiri
                elseif (strtoupper($cekdata->jalur) == 'MANDIRI') {
                    if ($setup && $setup->registrasi_mandiri) {
                        if (!status_jadwal($setup->registrasi_mandiri)) {
                            $ket_registrasi = 'Registrasi Akun Untuk Jalur ' . strtoupper($cekdata->jalur) . ' ' . 'Dimulai Tanggal ' . tgl_indo(pecah_jadwal($setup->registrasi_mandiri, 0)) . ' s/d ' . tgl_indo(pecah_jadwal($setup->registrasi_mandiri, 1));
                            $this->dispatch('alert', type: 'error', message: $ket_registrasi);
                            $err++;
                        }
                    } else {
                        $ket_registrasi = 'Registrasi Gagal, Admin Belum Tentukan Tanggal Registrasi ' . strtoupper($cekdata->jalur);
                        $this->dispatch('alert', type: 'error', message: $ket_registrasi);
                        $err++;
                    }
                }

                if (!$err) {
                    $this->get = [
                        'peserta_id' => $cekdata->id,
                        'nomor_peserta' => $cekdata->nomor_peserta,
                        'nisn' => $cekdata->nisn,
                        'email' => $cekdata->email,
                        'nama_peserta' => $cekdata->nama_peserta,
                        'prodi' => $cekdata->prodi->jenjang_prodi . ' - ' . $cekdata->prodi->nama_prodi,
                        'jalur' => $cekdata->jalur
                    ];

                    $this->peserta_id = $cekdata->id;

                    // dd($params);
                    $this->dispatch('alert', type: 'success', message: 'Identitas ditemukan, silahkan lengkapi kolom E-Mail Konfirmasi.');
                    $this->currentStep = 2;
                }
            }
        }
    }

    public function confirmReg()
    {
        $this->validate(
            [
                'email' => 'required|email|unique:users,email|unique:app_peserta,email,' . $this->peserta_id
            ],
            [
                'email.required' => 'Kolom Email jangan dikosongkan!',
                'email.email' => 'Format Email salah!',
                'email.unique' => 'Email sudah terdaftar!'
            ]
        );

        // alert()->success('Success', 'Silahkan cek inbox pada E-Mail anda dan setelah itu lakukan aktivasi akun.');
        // return $this->redirect(route('auth.registrasi'));

        $peserta = Pesertaukt::where('id', $this->peserta_id);
        $get = $peserta->first();

        // dd($get);

        /**
         * menangani peserta utk tidak melakukan pergantian email resgitrasi secara ualang2 krn email registrasi belum masuk inbox.
         * peserta dapat mengganti email registrasi jika:
         * 1. belum melakukan aktivasi akun
         * 2. menunggu beberapa menit agar dapat mengganti email, disini sistem mengijinkan 10 menit dari registrasi awal 
         */

        if ($get->registrasi) {
            $this->dispatch('alert', type: 'error', message: 'Nomor Peserta <b>' . $this->nomor_peserta . '</b> sudah melakukan registrasi!');
        } else {
            $err = 0;
            if ($get->email) {
                $jam_registrasi = Carbon::parse($get->updated_at);
                $jam_sekarang = Carbon::parse(now()->format('Y-m-d H:i:s'));
                $total_waktu = $jam_sekarang->diff($jam_registrasi);
                $total_hari = $total_waktu->d;
                $total_jam = $total_waktu->h;
                $total_menit = $total_waktu->i;

                if (($total_hari == 0) && ($total_jam == 0) && ($total_menit < 10)) {
                    $this->dispatch('alert', type: 'error', message: 'Tunggu beberapa saat lagi untuk mengganti/mengirim kembali E-Mail Konfirmasi!');
                    $err++;
                }
            }

            if (!$err) {
                $peserta->update([
                    'email' => $this->email,
                    'pass' => randomString(5)
                ]);

                SendMail::dispatch([
                    'email' => $this->email,
                    'get' => $get,
                    'content' => 'registrasi'
                ]);

                alert()->success('Success', 'Silahkan cek inbox pada E-Mail anda dan setelah itu lakukan aktivasi akun.');
                return $this->redirect(route('auth.registrasi'));
            }
        }
    }
}
