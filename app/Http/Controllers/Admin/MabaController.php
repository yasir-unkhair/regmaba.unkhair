<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateNPM;
use App\Models\Fakultas;
use App\Models\Pesertaukt;
use App\Models\ProsesData;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MabaController extends Controller
{
    //
    public function index(Request $request)
    {
        $setup = get_setup();
        if ($request->ajax()) {
            $peserta = Pesertaukt::with(['prodi'])
                ->join('app_peserta_has_verifikasiberkas AS b', 'app_peserta.id', '=', 'b.peserta_id')
                ->select(['app_peserta.id', 'app_peserta.prodi_id', 'app_peserta.jalur', 'app_peserta.nomor_peserta', 'app_peserta.nama_peserta', 'app_peserta.npm', 'b.vonis_ukt'])
                ->setup($setup->id)
                ->registrasi(true)
                ->status([5])
                ->where('b.bayar_ukt', 1)
                ->orderBy('app_peserta.jalur', 'ASC')->orderBy('app_peserta.prodi_id', 'ASC')->orderBy('app_peserta.npm', 'ASC')->orderBy('app_peserta.nama_peserta', 'ASC');
            return DataTables::eloquent($peserta)
                ->addIndexColumn()
                ->editColumn('prodi', function ($row) {
                    $str = ($row->prodi?->jenjang_prodi) . ' - ' . ($row->prodi?->nama_prodi);
                    return $str;
                })
                ->editColumn('ukt', function ($row) {
                    $str = strtoupper($row->vonis_ukt);
                    return $str;
                })
                ->editColumn('jalur', function ($row) {
                    return $row->jalur;
                })
                ->editColumn('proses', function ($row) {
                    if (strtolower($row->vonis_ukt) == 'kip-k') {
                        return 'Manual';
                    } else {
                        return 'Otomatis';
                    }
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
                ->rawColumns(['prodi', 'ukt', 'jalur', 'proses'])
                ->make(true);
        }

        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();
        $data = [
            'judul' => 'Daftar Maba ' . $setup->tahun,
            'fakultas' => $fakultas,
            'referensi' => master_referensi('Jalur Penerimaan'),
            'setup' => $setup,
            'datatable2' => [
                'url' => route('admin.maba.index'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'jalur', 'name' => 'jalur', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'ukt', 'name' => 'ukt', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'npm', 'name' => 'npm', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'proses', 'name' => 'proses', 'orderable' => 'false', 'searchable' => 'false'],
                ]
            ]
        ];

        return view('backend.admin.maba.index', $data);
    }

    public function generatenpm($params = NULL)
    {
        $peserta = NULL;
        $nomor_peserta = NULL;
        $notif_generatenpm = 0;

        if ($params && data_params($params, 'peserta_id')) {
            $peserta = Pesertaukt::with(['verifikasiberkas', 'setup'])->where('id', data_params($params, 'peserta_id'))->first();
            $notif_generatenpm = $peserta->prosesdata()->where(['queue' => 'generate-npm'])->count();
            $nomor_peserta = $peserta->nomor_peserta;
        }

        $data = [
            'judul' => 'Generate NPM',
            'peserta' => $peserta,
            'nomor_peserta' => $nomor_peserta,
            'notif_generatenpm' => $notif_generatenpm
        ];

        return view('backend.admin.maba.generatenpm', $data);
    }

    public function carimaba(Request $request)
    {
        $request->validate(
            [
                'nomor_peserta' => 'required|exists:app_peserta,nomor_peserta'
            ],
            [
                'nomor_peserta.required' => 'Nomor Peserta jangan dikosongkan!',
                'nomor_peserta.exists' => 'Nomor Peserta tidak ditemukan!'
            ]
        );

        $peserta = Pesertaukt::with('verifikasiberkas')->where('nomor_peserta', $request->nomor_peserta)->first();
        if (!$peserta->verifikasiberkas?->vonis_ukt) {
            return redirect(route('admin.maba.generatenpm'))->with(['message' => 'danger|Peserta dengan Identitas ' . $request->nomor_peserta . ' belum dilakukan verifikasi!']);
        } else {
            return redirect(route('admin.maba.generatenpm-params', encode_arr(['peserta_id' => $peserta->id])));
        }
    }

    public function actgeneratenpm($params)
    {
        $peserta_id = data_params($params, 'peserta_id');
        if ($params && $peserta_id) {

            // set notif
            ProsesData::updateOrCreate([
                'source' => $peserta_id,
                'queue' => 'generate-npm'
            ], [
                'source' => $peserta_id,
                'queue' => 'generate-npm'
            ]);

            // generate npm di jalankan
            dispatch(new GenerateNPM($peserta_id));
            alert()->success('Success', 'Perintah Generate NPM sedang dijalankan.');
        }
        return redirect(route('admin.maba.generatenpm-params', encode_arr(['peserta_id' => $peserta_id])));
    }
}
