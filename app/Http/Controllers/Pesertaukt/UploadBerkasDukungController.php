<?php

namespace App\Http\Controllers\Pesertaukt;

use App\Http\Controllers\Controller;
use App\Models\Pesertaukt;
use Illuminate\Http\Request;

class UploadBerkasDukungController extends Controller
{
    //
    public function index(Request $request)
    {
        if (!auth()->user()->formulirukt_selesai_input()) {
            alert()->error('Error', 'Anda belum melengkapi Formulir UKT, Silahkan lengkapi terlebih dahulu!');
            return redirect(route('peserta.dashboard'));
        }

        $peserta = Pesertaukt::with(['kondisikeluarga', 'pembiayaanstudi', 'berkasdukung'])->where('id', session('peserta_id'))->first();
        // dd($peserta, $peserta->berkasdukung);
        $kondisi = $peserta->kondisikeluarga->first();
        $biaya = $peserta->pembiayaanstudi->first();

        $berkasku = [];
        if ($peserta->berkasdukung) {
            $berkasku = $peserta->berkasdukung->get()->toArray();
        }

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
            'judul' => 'Upload Berkas Dukung',
            'dokumen' => $dokumen
        ];
        // dd($data);

        return view('backend.pesertaukt.berkasdukung', $data);
    }
}
