<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Pesertaukt;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PesertauktController extends Controller
{
    public function index(Request $request)
    {
        $setup = get_setup();
        if ($request->ajax()) {
            $user = User::where('id', auth()->user()->id)->first();
            $peserta = $user->verifikasipeserta()->where('app_peserta.setup_id', $setup->id);
            return DataTables::of($peserta)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $actionBtn = '
                    <center>
                        <a href="' . route('verifikator.pesertaukt.listdokumen', encode_arr(['peserta_id' => $row->peserta_id])) . '" class="btn btn-sm btn-warning" title="Verifikasi Peserta"><i class="fa fa-pencil"></i></a>
                        <a href="' . route('cetak.formverifikator',  encode_arr(['peserta_id' => $row->peserta_id])) . '" target="_blank" class="btn btn-sm btn-danger" title="Download Form Wawancara"><i class="fa fa-print"></i></a>
                    </center>';
                    return $actionBtn;
                })
                ->editColumn('ket_jalur', function ($row) {
                    return $row->jalur;
                })
                ->editColumn('prodi', function ($row) {
                    $str = ($row->jenjang_prodi) . ' - ' . ($row->nama_prodi);
                    return $str;
                })
                ->editColumn('keterangan', function ($row) {
                    $str = ($row->rekomendasi) ?  '<span class="text-success">Telah terverifikasi</span>' : '<span class="text-danger">Belum verifikasi</span>';
                    return $str;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('jalur')) {
                        $jalur = data_params($request->get('jalur'), 'jalur');
                        $instance->where('app_peserta.jalur', $jalur);
                    }

                    if ($request->get('prodi_id')) {
                        $instance->where('app_peserta.prodi_id', $request->get('prodi_id'));
                    }

                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('app_peserta.nomor_peserta', 'LIKE', "%$search%")->orWhere('app_peserta.nama_peserta', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['ket_jalur', 'prodi', 'keterangan', 'action'])
                ->make(true);
        }

        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();

        $data = [
            'judul' => 'Peserta UKT',
            'fakultas' => $fakultas,
            'referensi' => master_referensi('Jalur Penerimaan'),
            'setup' => $setup,
            'datatable2' => [
                'url' => route('verifikator.pesertaukt.index'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'ket_jalur', 'name' => 'ket_jalur', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'keterangan', 'name' => 'keterangan', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => 'false', 'searchable' => 'false']
                ]
            ]
        ];

        return view('backend.verifikator.pesertaukt.index', $data);
    }

    public function listdokumen($params)
    {
        $params = decode_arr($params);

        $peserta = Pesertaukt::with(['kondisikeluarga', 'pembiayaanstudi', 'berkasdukung', 'verifikasiberkas', 'prodi'])->where('id', $params['peserta_id'])->first();
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
            'judul' => 'Verifikasi Peserta UKT',
            'tab1' => $peserta,
            'tab2' => $kondisi,
            'tab3' => $biaya,
            'dokumen' => $dokumen
        ];

        return view('backend.verifikator.pesertaukt.verifikasiberkas', $data);
    }

    public function laporan(Request $request)
    {
        $setup = get_setup();
        if ($request->ajax()) {
            $user = User::where('id', auth()->user()->id)->first();
            $peserta = $user->verifikasipeserta()->where('app_peserta.setup_id', $setup->id);
            return DataTables::of($peserta)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $actionBtn = '
                    <center>
                        <a href="' . route('verifikator.pesertaukt.listdokumen', encode_arr(['peserta_id' => $row->peserta_id])) . '" class="btn btn-sm btn-warning" title="Verifikasi Peserta"><i class="fa fa-pencil"></i></a>
                        <a href="" class="btn btn-sm btn-danger" title="Download Form Wawancara"><i class="fa fa-print"></i></a>
                    </center>';
                    return $actionBtn;
                })
                ->editColumn('ket_jalur', function ($row) {
                    return $row->jalur;
                })
                ->editColumn('prodi', function ($row) {
                    $str = ($row->jenjang_prodi) . ' - ' . ($row->nama_prodi);
                    return $str;
                })
                ->editColumn('rekomendasi', function ($row) {
                    $str = ($row->rekomendasi) == 'wawancara' ? 'Wawancara' : strtoupper($row->rekomendasi);
                    return $str;
                })
                ->editColumn('tgl_verifikasi', function ($row) {
                    $str = tgl_indo($row->tgl_verifikasi);
                    return $str;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('jalur')) {
                        $jalur = data_params($request->get('jalur'), 'jalur');
                        $instance->where('app_peserta.jalur', $jalur);
                    }

                    if ($request->get('prodi_id')) {
                        $instance->where('app_peserta.prodi_id', $request->get('prodi_id'));
                    }

                    if ($request->get('rekomendasi')) {
                        $instance->where('app_peserta_has_verifikasiberkas.rekomendasi', $request->get('rekomendasi'));
                    }

                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('app_peserta.nomor_peserta', 'LIKE', "%$search%")->orWhere('app_peserta.nama_peserta', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['ket_jalur', 'prodi', 'keterangan', 'tgl_verifikasi'])
                ->make(true);
        }

        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();

        $data = [
            'judul' => 'Laporan Verifikasi',
            'fakultas' => $fakultas,
            'referensi' => master_referensi('Jalur Penerimaan'),
            'setup' => $setup,
            'datatable2' => [
                'url' => route('verifikator.pesertaukt.laporan'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'ket_jalur', 'name' => 'ket_jalur', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'rekomendasi', 'name' => 'rekomendasi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'tgl_verifikasi', 'name' => 'tgl_verifikasi', 'orderable' => 'false', 'searchable' => 'false']
                ]
            ]
        ];

        return view('backend.verifikator.pesertaukt.laporan', $data);
    }
}
