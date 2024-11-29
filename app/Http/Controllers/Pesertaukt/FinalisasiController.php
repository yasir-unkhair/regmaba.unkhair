<?php

namespace App\Http\Controllers\Pesertaukt;

use App\Http\Controllers\Controller;
use App\Models\Pesertaukt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinalisasiController extends Controller
{
    //
    public function index()
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

        if (!$peserta->akses_formulirukt()) {
            alert()->error('Error', 'Batas pengisian formulir UKT telah berakhir!');
            return redirect(route('peserta.dashboard'));
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
            'judul' => 'Finalisasi Pengajuan',
            'tab1' => $peserta,
            'tab2' => $kondisi,
            'tab3' => $biaya,
            'dokumen' => $dokumen
        ];
        // dd($data);

        return view('backend.pesertaukt.finalisasi', $data);
    }

    public function save(Request $request)
    {
        if (!auth()->user()->akses_formulirukt()) {
            alert()->error('Error', 'Gagal Finalisasi, Batas pengisian formulir UKT telah berakhir!');
            return redirect(route('peserta.dashboard'));
        }

        $validator = Validator::make(
            $request->all(),
            ['persetujuan' => 'required'],
            ['persetujuan.required' => 'Anda belum ceklis persetujuan!']
        );

        if ($validator->fails()) {
            alert()->error('Error', 'Anda belum ceklis persetujuan!');
            return redirect()->back()->withErrors($validator);
        }

        Pesertaukt::where('id', session('peserta_id'))->update(['status' => '3']);
        alert()->success('Success', 'Terimakasih anda sudah melakukan Finalisasi, dengan demikian maka anda tidak dapat lagi melakukan perubahan data.');
        return redirect(route('peserta.dashboard'));
    }
}
