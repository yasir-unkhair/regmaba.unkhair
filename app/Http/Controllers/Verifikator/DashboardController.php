<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $setup = get_setup();
        $peserta = User::where('id', auth()->user()->id)->first();

        $jml_snbp = 0;
        $jml_snbt = 0;
        $jml_mandiri = 0;

        foreach ($peserta->verifikasipeserta()->where('app_peserta.setup_id', $setup->id)->where('app_peserta.registrasi', true)->whereIn('app_peserta.status', [3, 4, 5])->get() as $row) {
            $jalur = strtolower($row->jalur);
            if ($jalur == 'snbp') {
                $jml_snbp++;
            }

            if ($jalur == 'snbt') {
                $jml_snbt++;
            }

            if ($jalur == 'mandiri') {
                $jml_mandiri++;
            }
        }

        $data = [
            'jml_snbp' => $jml_snbp,
            'jml_snbt' => $jml_snbt,
            'jml_mandiri' => $jml_mandiri,
            'total' => ($jml_snbp + $jml_snbt + $jml_mandiri),
            'tahun' => $setup->tahun
        ];

        return view('backend.verifikator.dashboard', $data);
    }
}
