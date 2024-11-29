<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VerifikatorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::role(['verifikator'])->where('is_active', true)->orderBy('id', 'DESC');
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->editColumn('user_simak', function ($row) {
                    return (!$row->user_simak) ? '<a class="badge badge-danger">Bukan</a>' : '<a class="badge badge-success">Ya</a>';
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['user_simak'])
                ->make(true);
        }

        $data = [
            'judul' => 'Daftar Verifikator',
            'datatable' => [
                'url' => route('admin.verifikator.index'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'name', 'name' => 'name', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'email', 'name' => 'email', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'user_simak', 'name' => 'user_simak', 'orderable' => 'false', 'searchable' => 'false']
                ]
            ]
        ];

        return view('backend.admin.verifikator.index', $data);
    }

    public function penugasan(Request $request)
    {
        if ($request->ajax()) {
            $setup = get_setup();
            $users = User::role('verifikator')->where('is_active', true)->orderBy('id', 'DESC');
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->editColumn('jalur', function ($row) {
                    if (request()->get('jalur')) {
                        return data_params(request()->get('jalur'), 'jalur');
                    }
                    return '';
                })
                ->editColumn('tahun', function ($row) use ($setup) {
                    if (request()->get('jalur')) {
                        return $setup->tahun;
                    }
                    return '';
                })
                ->editColumn('jml_peserta', function ($row) {
                    if (request()->get('jalur')) {
                        $jalur = data_params(request()->get('jalur'), 'jalur');
                        return $row->verifikasipeserta()->where('app_peserta.jalur', $jalur)->count();
                    }
                    return '';
                })
                ->editColumn('action', function ($row) {
                    $actionBtn = '';
                    if (request()->get('jalur')) {
                        $jalur = data_params(request()->get('jalur'), 'jalur');
                        $actionBtn = '
                            <div class="btn-group btn-block">
                                <a href="' . route('admin.verifikator.daftarpeserta', encode_arr(['verifikator_id' => $row->id, 'jalur' => $jalur])) . '" class="btn btn-sm btn-success" title="Daftar Peserta"><i class="fa fa-list"></i> Daftar</a>
                                <a href="' . route('admin.verifikator.plotting', encode_arr(['verifikator_id' => $row->id, 'jalur' => $jalur])) . '" class="btn btn-sm btn-warning" title="Penugasan Verifikator"><i class="fa fa-user-plus"></i> Penugasan</a>
                            </div>
                        ';
                    }
                    return $actionBtn;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['jalur', 'tahun', 'jml_peserta', 'action'])
                ->make(true);
        }

        $data = [
            'judul' => 'Penugasan Verifikator',
            'referensi' => master_referensi('Jalur Penerimaan'),
            'datatable2' => [
                'url' => route('admin.verifikator.penugasan'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'name', 'name' => 'name', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'jalur', 'name' => 'jalur', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'tahun', 'name' => 'tahun', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'jml_peserta', 'name' => 'jml_peserta', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'action', 'name' => 'action', 'orderable' => 'false', 'searchable' => 'false']
                ]
            ]
        ];

        return view('backend.admin.verifikator.penugasan', $data);
    }

    public function plotting($params)
    {
        $params = decode_arr($params);
        $data = [
            'judul' => 'Plotting Verifikator',
            'jalur' => $params['jalur'],
            'params' => encode_arr($params)
        ];

        return view('backend.admin.verifikator.plotting', $data);
    }

    public function daftarpeserta(Request $request, $params)
    {
        $params = decode_arr($params);
        $user = User::with('verifikasipeserta')->where('id', $params['verifikator_id'])->first();
        $peserta = $user->verifikasipeserta()->where('app_peserta.jalur', $params['jalur']);
        if ($request->ajax()) {
            return DataTables::of($peserta)
                ->addIndexColumn()
                ->addColumn('prodi', function ($row) {
                    return $row->jenjang_prodi . ' - ' . $row->nama_prodi;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('prodi_id')) {
                        $instance->where('prodi_id', $request->get('prodi_id'));
                    }

                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('nomor_peserta', 'LIKE', "%$search%")
                                ->orWhere('nama_peserta', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['prodi'])
                ->make(true);
        }

        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();
        $setup = get_setup();
        $data = [
            'judul' => 'Daftar Peserta UTK Verifikator',
            'fakultas' => $fakultas,
            'user' => $user,
            'jalur' => $params['jalur'],
            'tahun' => $setup->tahun,
            'jml_peserta' => $peserta->count(),
            'params' => encode_arr($params),
            'datatable2' => [
                'url' => route('admin.verifikator.daftarpeserta', encode_arr($params)),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false']
                ]
            ]
        ];

        return view('backend.admin.verifikator.daftarpeserta', $data);
    }
}
