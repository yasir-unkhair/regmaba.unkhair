<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesertaukt;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setup = get_setup();
        if ($request->ajax()) {
            $peserta = Pesertaukt::with(['prodi'])->where('setup_id', $setup->id)->orderBy('jalur', 'ASC')->orderBy('prodi_id', 'ASC')->orderBy('nama_peserta', 'ASC');
            return DataTables::eloquent($peserta)
                ->addIndexColumn()
                ->editColumn('ket_jalur', function ($row) {
                    return $row->jalur;
                })
                ->editColumn('prodi', function ($row) {
                    $str = ($row->prodi?->jenjang_prodi) . ' - ' . ($row->prodi?->nama_prodi);
                    return $str;
                })
                ->editColumn('status', function ($row) {
                    $str = (!$row->registrasi) ? '<a class="badge badge-danger">Belum Mendaftar</a>' : '<a class="badge badge-success">Sudah Mendaftar</a>';
                    return $str;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('jalur')) {
                        $jalur = data_params($request->get('jalur'), 'jalur');
                        $instance->where('jalur', $jalur);
                    }

                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('nomor_peserta', 'LIKE', "%$search%")->orWhere('nama_peserta', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['ket_jalur', 'prodi', 'status'])
                ->make(true);
        }

        $data = [
            'judul' => 'Data Peserta',
            'referensi' => master_referensi('Jalur Penerimaan', ['id', 'referensi']),
            'setup' => $setup,
            'datatable2' => [
                'url' => route('admin.datapeserta.index'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'nomor_peserta', 'name' => 'nomor_peserta', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'nama_peserta', 'name' => 'nama_peserta', 'orderable' => 'true', 'searchable' => 'true'],
                    ['data' => 'prodi', 'name' => 'prodi', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'ket_jalur', 'name' => 'ket_jalur', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'status', 'name' => 'status', 'orderable' => 'false', 'searchable' => 'false'],
                ]
            ]
        ];

        return view('backend.admin.data-peserta.index', $data);
    }

    public function uploaddata($jalur)
    {
        $setup = get_setup();
        $data = [
            'judul' => 'Upload Data Peserta',
            'setup' => $setup,
            'jalur' => data_params($jalur, 'jalur')
        ];

        return view('backend.admin.data-peserta.upload', $data);
    }

    public function actuploaddata(Request $request)
    {
        $data = json_decode(request('data'));
        $errors = [];

        $validator = Validator::make($request->all('data'), ['data' => ['required']], [
            'data.required' => 'Data Peserta wajib di isi minimal 1 data.'
        ]);
        if ($validator->fails()) {
            $errors['data'] = $validator->errors();
        }

        if ($errors) {
            return redirect()->back()->with('galat', $errors)->withInput();
        }

        $formattedData = [];
        foreach ($data as $index => $row) {
            if (trim($row->nomor_peserta) && trim($row->nama_peserta) && trim($row->kode_prodi)) {
                $formattedData[] = [
                    'baris' => ($index + 1),
                    'nomor_peserta' => $row->nomor_peserta ? trim($row->nomor_peserta) : NULL,
                    'nisn' => $row->nisn ? trim($row->nisn) : NULL,
                    'nama_peserta' => $row->nama_peserta ? trim($row->nama_peserta) : NULL,
                    // 'jk' => $row->jk ? trim($row->jk) : NULL,
                    'kode_prodi' => $row->kode_prodi ? trim($row->kode_prodi) : NULL,
                    'tpl_lahir' => $row->tpl_lahir ? trim($row->tpl_lahir) : NULL,
                    'tgl_lahir' => $row->tgl_lahir ? trim($row->tgl_lahir) : NULL,
                    // 'nik' => $row->nik ? trim($row->nik) : NULL,
                    // 'alamat_asal' => $row->alamat_asal ? trim($row->alamat_asal) : NULL,
                    'npsn' => $row->npsn ? trim($row->npsn) : NULL,
                    'sekolah_asal' => $row->sekolah_asal ? trim($row->sekolah_asal) : NULL,
                    'nomor_kip' => $row->nomor_kip ? trim($row->nomor_kip) : NULL,
                    'pebanding_penghasilan_ayah' => $row->pebanding_penghasilan_ayah ? trim($row->pebanding_penghasilan_ayah) : NULL,
                    'pebanding_penghasilan_ibu' => $row->pebanding_penghasilan_ibu ? trim($row->pebanding_penghasilan_ibu) : NULL,
                ];
            }
        }


        $validator = Validator::make($request->all('jalur'), ['jalur' => ['required']], [
            'jalur.required' => 'Jalur jangan dikosongkan!'
        ]);
        if ($validator->fails()) {
            $errors['jalur'] = $validator->errors();
        }

        foreach ($formattedData as $data) {
            $kode_prodi = $data['kode_prodi'];
            $validator = Validator::make($data, [
                'nomor_peserta' => ['required', 'numeric', 'unique:app_peserta,nomor_peserta'],
                'nisn' => ['required', 'numeric'],
                'nama_peserta' => ['required'],
                'kode_prodi' => ['required', function ($attribute, $value, $fail) use ($kode_prodi) {
                    if ($kode_prodi) {
                        $cek = Prodi::where('kode_prodi', $kode_prodi)->orWhere('kode_prodi_dikti', $kode_prodi)->first();
                        if (!$cek) {
                            $fail("Kode Prodi '" . $kode_prodi . "' tidak dikenali!");
                        }
                    }
                }],
                'npsn' => ['required', 'numeric'],
                'sekolah_asal' => ['required']
            ], [
                'nomor_peserta.required' => 'Nomor Peserta jangan dikosongkan!',
                'nomor_peserta.numeric' => 'Nomor Peserta harus berbentuk angka!',
                'nomor_peserta.unique' => 'Nomor Peserta sudah terdaftar!',

                'nisn.required' => 'NISN jangan dikosongkan!',
                'nisn.numeric' => 'NISN harus berbentuk angka!',

                'nama_peserta.required' => 'Nama Peserta jangan dikosongkan!',

                'kode_prodi.required' => 'Kode Prodi jangan dikosongkan!',
                'kode_prodi.exists' => 'Kode Prodi tidak dikenali!',

                'npsn.required' => 'NPSN jangan dikosongkan!',
                'npsn.numeric' => 'NPSN harus berbentuk angka!',

                'sekolah_asal.required' => 'Sekolah Asal jangan dikosongkan!',
            ]);

            if ($validator->fails()) {
                $errors['peserta'][] = [
                    'baris' => $data['baris'],
                    'errors' => $validator->errors()
                ];
            }
        }

        if ($errors) {
            return redirect()->back()->with('galat', $errors)->withInput();
        }

        foreach ($formattedData as $row) {
            $prodi = Prodi::where('kode_prodi', trim($row['kode_prodi']))->orWhere('kode_prodi_dikti', trim($row['kode_prodi']))->first();
            $peserta = Pesertaukt::create([
                'prodi_id' => $prodi->id,
                'fakultas_id' => $prodi->fakultas_id,
                'setup_id' => request()->input('setup_id'),
                'jalur' => request()->input('jalur'),
                'nomor_peserta' => trim($row['nomor_peserta']),
                'nama_peserta' => ucwords(strtolower(trim($row['nama_peserta']))),
                // 'nik' => $row['nik'],
                'nisn' => $row['nisn'],
                'npsn' => $row['npsn'],
                'sekolah_asal' => $row['sekolah_asal'],
                // 'jk' => $row['jk'],
                'kip' => $row['nomor_kip'],
                'jpeserta' => (strlen($row['nomor_kip']) > 3) ? 'KIP-K' : 'Non KIP-K',
                // 'alamat_asal' => $row['alamat_asal'],
                'tpl_lahir' => ucwords(strtolower($row['tpl_lahir'])),
                'tgl_lahir' => $row['tgl_lahir']
            ]);
            $peserta->kondisikeluarga()->updateOrCreate(
                [
                    'peserta_id' => $peserta->id
                ],
                [
                    'peserta_id' => $peserta->id,
                    'pebanding_penghasilan_ayah' => $row['pebanding_penghasilan_ayah'],
                    'pebanding_penghasilan_ibu' => $row['pebanding_penghasilan_ayah']
                ]
            );

            $peserta->pembiayaanstudi()->updateOrCreate(
                [
                    'peserta_id' => $peserta->id
                ],
                [
                    'peserta_id' => $peserta->id
                ]
            );
        }

        alert()->success('Success', 'Berhasil import ' . count($formattedData) . ' data peserta');
        return redirect(route('admin.datapeserta.index'))->withInput(['jalur' => encode_arr(['jalur' => request()->input('jalur')])]);
    }
}
