<?php

namespace App\Http\Controllers\Pesertaukt;

use App\Http\Controllers\Controller;
use App\Models\Pesertaukt;
use App\Models\PesertauktPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use PDF;

class PembayaranController extends Controller
{
    //
    public function index(Request $request)
    {
        $peserta = Pesertaukt::with(['verifikasiberkas', 'pembayaran', 'prodi', 'setup'])->where('id', session('peserta_id'))->first();
        if ($peserta->pembayaran()->count() == 0) {
            // jalur mandiri
            $pembayaran[] = [
                'jenis_pembayaran' => 'ukt',
                'detail_pembayaran' => 'Pembayaran UKT  ' . ucwords($peserta->verifikasiberkas->vonis_ukt) . ' Tahun ' . $peserta->setup->tahun,
                'bank' => 'BTN',
                'amount' => $peserta->verifikasiberkas->nominal_ukt
            ];

            // jalur mandiri
            if ($peserta->jalur == 'MANDIRI') {
                $pembayaran[] = [
                    'jenis_pembayaran' => 'ipi',
                    'detail_pembayaran' => 'Pembayaran Iuran Pengembangan Institusi (IPI)',
                    'bank' => 'BTN',
                    'amount' => $peserta->verifikasiberkas->nominal_ipi
                ];
            }

            if (in_array($peserta->prodi->kode_prodi, ['11201', '73201', '48201'])) {
                // nominal pemkes prodi kedokteran, psikologi, dan farmasi
                $ket = '
                    <p>
                        1. Pemeriksaan Dokter Umum Fisik Lengkap Rp. 75.000,<br>
                        2. Pemeriksaan Virus, Tes Buta Warna Rp. 75.000,<br>
                        3. Pemeriksaan Narkoba 3 Parameter Rp. 250.000,<br>
                        4. Pemeriksaan HbSAg Rp. 150.000,<br>
                        5. Pemeriksaan MMPI Rp, 400.000,<br>
                        6. Administrasi Rp. 10.000
                    </p>';

                $pembayaran[] = [
                    'jenis_pembayaran' => 'pemkes',
                    'detail_pembayaran' => 'Pemeriksaan Kesehatan Mahasiswa Baru ' . $peserta->setup->tahun . $ket,
                    'bank' => 'BTN',
                    'amount' => '960000'
                ];
            } else {
                $ket = '
                    <p>
                        1. Pemeriksaan Dokter Umum Fisik Lengkap Rp. 75.000,<br>
                        2. Pemeriksaan Virus, Tes Buta Warna Rp. 75.000,<br>
                        3. Pemeriksaan Narkoba 3 Parameter Rp. 250.000,<br>
                        4. Administrasi Rp. 10.000
                    </p>';

                $pembayaran[] = [
                    'jenis_pembayaran' => 'pemkes',
                    'detail_pembayaran' => 'Pemeriksaan Kesehatan Mahasiswa Baru ' . $peserta->setup->tahun . $ket,
                    'bank' => 'BTN',
                    'amount' => '410000',
                ];
            }


            $peserta->pembayaran()->createMany($pembayaran);
            return redirect(route('peserta.pembayaran'));
        }

        if ($request->ajax()) {
            $pembayaran = $peserta->pembayaran()->orderBy(DB::raw('FIELD(jenis_pembayaran, "ukt", "ipi", "pemkes")'));
            return DataTables::of($pembayaran)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $actionBtn = '
                    <center>
                        <a href="' . route('peserta.pembayaran.detail', encode_arr(['pembayaran_id' => $row->id])) . '" class="btn btn-sm btn-info" title="Detail Pembayaran">
                            <i class="fa fa-list"></i>
                        </a>
                    </center>';
                    return $actionBtn;
                })
                ->editColumn('detail_pembayaran', function ($row) {
                    return $row->detail_pembayaran;
                })
                ->editColumn('bank', function ($row) {
                    return '<div class="text-center">' . $row->bank . '</spam>';
                })
                ->editColumn('amount', function ($row) {
                    return '<div class="text-right">' . rupiah($row->amount) . '</spam>';
                })
                ->editColumn('status', function ($row) {
                    return status_pembayaran($row->lunas);
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->input('search.value'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->input('search.value');
                            $w->orWhere('detail_pembayaran', 'LIKE', "%$search%")->orWhere('bank', 'LIKE', "%$search%");
                        });
                    }
                })
                ->escapeColumns([])
                ->rawColumns(['action', 'amount', 'bank', 'status'])
                ->make(true);
        }

        $data = [
            'judul' => 'Pembayaran',
            'datatable' => [
                'url' => route('peserta.pembayaran'),
                'id_table' => 'id-datatable',
                'columns' => [
                    ['data' => 'action', 'name' => 'action', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'detail_pembayaran', 'name' => 'detail_pembayaran', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'bank', 'name' => 'bank', 'orderable' => 'false', 'searchable' => 'true'],
                    ['data' => 'amount', 'name' => 'amount', 'orderable' => 'false', 'searchable' => 'false'],
                    ['data' => 'status', 'name' => 'status', 'orderable' => 'false', 'searchable' => 'false']
                ]
            ]
        ];

        return view('backend.pesertaukt.pembayaran', $data);
    }

    public function detail($params)
    {
        $data = [
            'judul' => 'Detail Pembayaran',
            'params' => $params
        ];
        return view('backend.pesertaukt.detailpembayaran', $data);
    }

    public function cetak($id)
    {
        $pembayaran = PesertauktPembayaran::where('id', $id)->first();
        return $this->__download_slip($pembayaran);
    }

    private function __download_slip($pembayaran)
    {
        // dd($pembayaran);
        $data = [
            'pembayaran' => $pembayaran
        ];

        $file_template = (strtolower($pembayaran->bank) == 'btn') ? 'pdf.slip-pembayaran-btn' : 'pdf.slip-pembayaran-bni';

        PDF::setOption('P', 'A4', 'fr', true, 'UTF-8', array(20, 20, 20, 20));
        $pdf = PDF::loadView($file_template, $data);

        $judul = time() . ' - Slip Pembayaran - ' . $pembayaran->peserta->nama_peserta;
        return $pdf->download($judul . '.pdf', 'I');
        // return $pdf->output;
    }
}
