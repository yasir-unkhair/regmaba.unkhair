<?php

namespace App\Http\Controllers\Pesertaukt;

use App\Http\Controllers\Controller;
use App\Models\Pesertaukt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $peserta = Pesertaukt::where('id', session('peserta_id'))->first();
        $data = [
            'judul' => 'Dashboard',
            'peserta' => $peserta
        ];

        return view('backend.pesertaukt.dashboard', $data);
    }

    public function resume()
    {
        $peserta = auth()->user();
        if (!$peserta->formulirukt_selesai_input()) {
            alert()->error('Error', 'Anda belum melengkapi Formulir UKT, Silahkan lengkapi terlebih dahulu!');
            return redirect(route('peserta.dashboard'));
        }

        if ($peserta->status_peserta() == 1) {
            alert()->error('Error', 'Anda belum Upload Berkas Bukti Dukung, Silahkan upload terlebih dahulu!');
            return redirect(route('peserta.berkasdukung'));
        }

        if ($peserta->status_peserta() == 2) {
            alert()->error('Error', 'Segera melakukan finalisasi agar data pengajuan anda segera di proses verifikasi oleh panitia.');
            return redirect(route('peserta.finalisai'));
        }

        $peserta = Pesertaukt::with(['kondisikeluarga', 'pembiayaanstudi', 'berkasdukung', 'prodi'])->where('id', session('peserta_id'))->first();
        $kondisi = $peserta->kondisikeluarga->first();
        $biaya = $peserta->pembiayaanstudi->first();
        $berkasku = $peserta->berkasdukung->get()->toArray();

        $dokumen = [];
        foreach (list_dokumen_upload($kondisi->keberadaan_ortu, $biaya->biaya_studi) as $row) {
            if ($row['urutan'] == 'label') {
                $dokumen[] = $row['keterangan'];
            } else {
                $collection = collect($berkasku);
                $res = $collection->firstWhere('dokumen', $row['dokumen']);
                $dokumen[] = [
                    'urutan' => $row['urutan'],
                    'dokumen' => $row['dokumen'],
                    'detail' => $row['detail'],
                    'wajib' => $row['wajib'],
                    'upload' => $res
                ];
            }
        }

        $data = [
            'judul' => 'Resume Pengajuan',
            'tab1' => $peserta,
            'tab2' => $kondisi,
            'tab3' => $biaya,
            'dokumen' => $dokumen
        ];
        // dd($data);

        return view('backend.pesertaukt.resume', $data);
    }
}
