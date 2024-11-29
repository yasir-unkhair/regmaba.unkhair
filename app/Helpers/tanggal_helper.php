<?php
if (!function_exists('pecah_jadwal')) {
    function pecah_jadwal($tahapan, $key)
    {
        if ($tahapan) {
            $pecah = explode(" - ", $tahapan);
            return array_key_exists($key, $pecah) ? trim($pecah[$key]) : NULL;
        }
        return NULL;
    }
}
if (!function_exists('status_jadwal')) {
    function status_jadwal($tahapan, $return = 'boolean')
    {
        if (!$tahapan || $tahapan == ' - ' || strlen($tahapan) <= 3) {
            return FALSE;
        }

        $pecah = explode(" - ", $tahapan);
        $tgl_sekarang = date('Y/m/d H:i');

        $konvert_tgl_mulai   = date('Y/m/d H:i', strtotime(trim($pecah[0])));
        $konvert_tgl_selesai = date('Y/m/d H:i', strtotime(trim($pecah[1])));

        if ($return == 'string') {
            if (strtotime($tgl_sekarang) < strtotime($konvert_tgl_mulai)) {
                return 'segera';
            }

            if ((strtotime($tgl_sekarang) >= strtotime($konvert_tgl_mulai)) && (strtotime($tgl_sekarang) <= strtotime($konvert_tgl_selesai))) {
                return 'dalam-proses';
            }

            if (strtotime($tgl_sekarang) > strtotime($konvert_tgl_selesai)) {
                return 'selesai';
            }
        }
        /***
         * cek tanggal 
         * **/
        if ((strtotime($tgl_sekarang) >= strtotime($konvert_tgl_mulai)) && (strtotime($tgl_sekarang) <= strtotime($konvert_tgl_selesai))) {
            return TRUE;
        }
        return FALSE;
    }
}

if (!function_exists('range_tanggal')) {
    function range_tanggal($tahapan)
    {
        if ($tahapan) {
            $pecah = explode(" - ", $tahapan);
            $tgl_start = date('Y/m/d H:i', strtotime($pecah[0]));
            $tgl_end = date('Y/m/d H:i', strtotime($pecah[1]));

            //echo $tgl_mulai.' <> '.$tgl_start;
            //die;

            $tgl1 = new DateTime($tgl_start);
            $tgl2 = new DateTime($tgl_end);
            $jarak = $tgl2->diff($tgl1);
            return $jarak;
        }
        return (object) array('d' => NULL, 'h' => NULL, 'i' => NULL);
    }
}

if (!function_exists('format_tanggal')) {
    function format_tanggal($tgl)
    {
        if (!$tgl) {
            return '';
        }

        $pecah = explode(" ", $tgl);
        if (count($pecah) > 1) {
            return tgl_indo(ltrim($pecah[0])) . ' ' . date('H:i', strtotime(rtrim($pecah[1])));
        }
        return tgl_indo(trim($tgl));
    }
}


if (!function_exists('filter')) {
    function filter($data)
    {
        $data = trim($data);
        return $data ? $data : null;
    }
}

if (!function_exists('tgl_indo')) {
    function tgl_indo($tgl, $time = TRUE)
    {
        if (!$tgl) {
            return '';
        }
        $date = \Carbon\Carbon::parse($tgl)->locale('id');

        $date->settings(['formatFunction' => 'translatedFormat']);

        if (!$time) {
            return $date->format('j M Y');
        }
        return $date->format('j M Y H:i');
    }
}

if (!function_exists('hari_indo')) {
    function hari_indo($tgl)
    {
        if (!$tgl) {
            return '';
        }

        $date = \Carbon\Carbon::parse($tgl)->locale('id');

        $date->settings(['formatFunction' => 'translatedFormat']);

        return $date->format('l');
    }
}

// function untuk menampilkan nama hari ini dalam bahasa indonesia
// di buat oleh malasngoding.com
if (!function_exists('hari_ini')) {
    function hari_ini()
    {
        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }

        return $hari_ini;
    }
}

if (!function_exists('bool_tgl_pembayaran')) {
    function bool_tgl_pembayaran($tgl_pembayaran)
    {
        if (!$tgl_pembayaran) {
            return FALSE;
        }

        $tgl_sekarang = date('Y-m-d H:i');

        $konvert_tgl_pembayaran   = date('Y-m-d H:i', strtotime($tgl_pembayaran));

        /***
         * cek tanggal 
         * **/
        if (strtotime($tgl_sekarang) <= strtotime($konvert_tgl_pembayaran)) {
            return TRUE;
        }
        return FALSE;
    }
}
