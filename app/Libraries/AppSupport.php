<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;

class AppSupport
{
    private $message;
    public function GenerateNpm($setup_id, $tahun, $prefix_npm)
    {
        $angkatan = substr($tahun, -2, 2);
        $statis = '11';
        $kdd = $prefix_npm . $angkatan . $statis;
        $nom = DB::table('app_peserta')->select(['npm'])
            ->where('setup_id', $setup_id)
            ->whereRaw('SUBSTRING(npm,1,8)=?', [$kdd])
            ->orderBy('npm', 'DESC')
            ->limit(1)->first();

        $npm = '';
        if (!$nom) {
            $npm = $prefix_npm . $angkatan . $statis . '001';
        } else {
            $noakhir = substr($nom->npm, 8, 3) + 1;
            $jno = strlen($noakhir);
            if ($jno == 1) {
                $jum = '00' . $noakhir;
            } elseif ($jno == 2) {
                $jum = '0' . $noakhir;
            } elseif ($jno == 3) {
                $jum = $noakhir;
            }
            $npm = $prefix_npm . $angkatan . $statis . $jum;
        }

        return $npm;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
