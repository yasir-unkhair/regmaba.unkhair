<?php

namespace App\Http\Controllers\Pesertaukt;

use App\Http\Controllers\Controller;
use App\Models\Pesertaukt;
use Illuminate\Http\Request;

class StatusuktController extends Controller
{
    //
    public function index()
    {
        $peserta = Pesertaukt::with(['verifikasiberkas', 'setup', 'prodi'])->where('id', session('peserta_id'))->first();
        // $verifikasi = $peserta->verifikasi()->first();
        // $setup = $peserta->setup()->first();
        $jalurmasuk = $peserta->jalur;

        $tgl_pembayaran_ukt = '';
        if ($jalurmasuk == 'SNBP') {
            $tgl_pembayaran_ukt = $peserta->setup?->pembayaran_snbp;
        } elseif ($jalurmasuk == 'SNBT') {
            $tgl_pembayaran_ukt = $peserta->setup?->pembayaran_snbt;
        } else {
            $tgl_pembayaran_ukt = $peserta->setup?->pembayaran_mandiri;
        }

        // dd($setup, $jalurmasuk, $tgl_pembayaran_ukt);

        $notif_generatenpm = $peserta->prosesdata()->where(['queue' => 'generate-npm'])->count();

        $data = [
            'judul' => 'Status UKT',
            'peserta' => $peserta,
            'tgl_pembayaran_ukt' => $tgl_pembayaran_ukt,
            'notif_generatenpm' => $notif_generatenpm
        ];

        // dd($data);

        return view('backend.pesertaukt.statusukt', $data);
    }
}
