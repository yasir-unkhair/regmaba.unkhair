<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Pesertaukt;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PesertauktController extends Controller
{
    public function index(Request $request)
    {
        $setup = get_setup();
        if ($request->ajax()) {
            $peserta = Pesertaukt::with(['prodi', 'verifikasiberkas'])->setup($setup->id)->registrasi(true)->status([3, 4, 5])->orderBy('jalur', 'ASC')->orderBy('prodi_id', 'ASC')->orderBy('nama_peserta', 'ASC');
            return DataTables::eloquent($peserta)
                ->addIndexColumn()
                ->editColumn('ket_jalur', function ($row) {
                    return $row->jalur;
                })
                ->editColumn('prodi', function ($row) {
                    $str = ($row->prodi?->jenjang_prodi) . ' - ' . ($row->prodi?->nama_prodi);
                    return $str;
                })
                ->editColumn('verifikator', function ($row) {
                    $str = $row->verifikasiberkas?->verifikator?->name ?? '-';
                    return $str;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('jalur')) {
                        $jalur = data_params($request->get('jalur'), 'jalur');
                        $instance->where('jalur', $jalur);
                    }

                    if ($request->get('prodi_id')) {
                        $instance->where('app_peserta.prodi_id', $request->get('prodi_id'));
                    }

                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('nomor_peserta', 'LIKE', "%$search%")->orWhere('nama_peserta', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['ket_jalur', 'prodi', 'verifikator'])
                ->make(true);
        }

        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();
        $data = [
            'judul' => 'Peserta UKT',
            'fakultas' => $fakultas,
            'referensi' => master_referensi('Jalur Penerimaan'),
            'setup' => $setup,
            'datatable2' => [
                'url' => route('admin.pesertaukt.index'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'ket_jalur', 'name' => 'ket_jalur', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'verifikator', 'name' => 'verifikator', 'orderable' => 'false', 'searchable' => 'false']
                ]
            ]
        ];

        return view('backend.admin.pesertaukt.index', $data);
    }
}
