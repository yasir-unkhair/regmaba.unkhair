<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Pesertaukt;
use App\Models\PesertauktVerifikasiBerkas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenetapanuktController extends Controller
{
    public function index(Request $request)
    {
        $setup = get_setup();
        if ($request->ajax()) {
            $peserta = Pesertaukt::with(['prodi', 'verifikasiberkas'])->setup($setup->id)->registrasi(true)->status([3, 4, 5])->orderBy('jalur', 'ASC')->orderBy('prodi_id', 'ASC')->orderBy('nama_peserta', 'ASC');
            return DataTables::eloquent($peserta)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $disabled = $row->verifikasiberkas?->rekomendasi ? '' : 'disabled';
                    $onclick = "modal_penetapanukt(' " . encode_arr(['peserta_id' => $row->id]) . " ')";
                    if ($disabled == 'disabled') {
                        $onclick = '';
                    }

                    $actionBtn = '
                    <center>
                        <button type="button" onclick="' . $onclick . '" class="btn btn-sm btn-primary" title="Vonis UKT Peserta" ' . $disabled . '><i class="fa fa-legal"></i></button>
                        <a href="' . route('admin.penetapanukt.listdokumen', encode_arr(['peserta_id' => $row->id])) . '" class="btn btn-sm btn-warning" title="Verifikasi Peserta"><i class="fa fa-pencil"></i></a>
                        <a href="' . route('cetak.formverifikator',  encode_arr(['peserta_id' => $row->id])) . '" target="_blank" class="btn btn-sm btn-danger ' . $disabled . '" title="Download Form Wawancara"><i class="fa fa-print"></i></a>
                    </center>';
                    return $actionBtn;
                })
                ->editColumn('prodi', function ($row) {
                    $str = ($row->prodi?->jenjang_prodi) . ' - ' . ($row->prodi?->nama_prodi);
                    return $str;
                })
                ->editColumn('rekomendasi', function ($row) {
                    $str = '<span class="text-danger">Belum verifikasi</span>';
                    if ($row->verifikasiberkas?->rekomendasi) {
                        $str = ($row->verifikasiberkas?->rekomendasi) == 'wawancara' ? 'Wawancara' : strtoupper($row->verifikasiberkas?->rekomendasi ?? '');
                    }
                    return $str;
                })
                ->editColumn('status', function ($row) {
                    $str = ($row->verifikasiberkas?->vonis_ukt) ?  strtoupper($row->verifikasiberkas?->vonis_ukt) : '<span class="text-danger">Belum penetapan!</span>';
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
                ->rawColumns(['prodi', 'rekomendasi', 'status', 'action'])
                ->make(true);
        }

        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();
        $data = [
            'judul' => 'Penetapan UKT',
            'fakultas' => $fakultas,
            'referensi' => master_referensi('Jalur Penerimaan'),
            'setup' => $setup,
            'datatable2' => [
                'url' => route('admin.penetapanukt.index'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'rekomendasi', 'name' => 'rekomendasi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'status', 'name' => 'status', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                ]
            ]
        ];

        return view('backend.admin.penetapanukt.index', $data);
    }

    public function listdokumen($params)
    {
        $params = decode_arr($params);
        // dd($params);
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

        return view('backend.admin.penetapanukt.verifikasiberkas', $data);
    }

    public function laporan(Request $request)
    {
        $setup = get_setup();
        if ($request->ajax()) {
            $peserta = Pesertaukt::with(['prodi'])
                ->join('app_peserta_has_verifikasiberkas as b', 'app_peserta.id', '=', 'b.peserta_id')
                ->join('users as c', 'b.user_id_vonis', '=', 'c.id')
                ->select(['app_peserta.id', 'app_peserta.prodi_id', 'app_peserta.jalur', 'app_peserta.nomor_peserta', 'app_peserta.nama_peserta', 'b.vonis_ukt', 'b.tgl_vonis', 'c.name'])
                ->setup($setup->id)
                ->registrasi(true)
                ->status([5])
                ->orderBy('jalur', 'ASC')->orderBy('prodi_id', 'ASC')->orderBy('nama_peserta', 'ASC');
            return DataTables::eloquent($peserta)
                ->addIndexColumn()
                ->editColumn('prodi', function ($row) {
                    $str = ($row->prodi?->jenjang_prodi) . ' - ' . ($row->prodi?->nama_prodi);
                    return $str;
                })
                ->editColumn('status', function ($row) {
                    $str = strtoupper($row->vonis_ukt);
                    return $str;
                })
                ->editColumn('jalur', function ($row) {
                    return $row->jalur;
                })
                ->editColumn('keterangan', function ($row) {
                    $str = '<b>Ditetapkan:</b> <i>' . tgl_indo($row->tgl_vonis) . '</i>';
                    $str .= '<br><b>Oleh:</b> <i>' . $row->name . '</i>';
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

                    if ($request->get('vonis')) {
                        $instance->where('b.vonis_ukt', $request->get('vonis'));
                    }

                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('app_peserta.nomor_peserta', 'LIKE', "%$search%")->orWhere('app_peserta.nama_peserta', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['prodi', 'status', 'keterangan'])
                ->make(true);
        }

        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();
        $data = [
            'judul' => 'Laporan Peserta UKT',
            'fakultas' => $fakultas,
            'referensi' => master_referensi('Jalur Penerimaan'),
            'setup' => $setup,
            'datatable2' => [
                'url' => route('admin.penetapanukt.laporan'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'jalur', 'name' => 'jalur', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'status', 'name' => 'status', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'keterangan', 'name' => 'keterangan', 'orderable' => 'false', 'searchable' => 'false'],
                ]
            ]
        ];

        return view('backend.admin.penetapanukt.laporan', $data);
    }
}
