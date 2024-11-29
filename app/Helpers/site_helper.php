<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

if (!function_exists('roles')) {
    function roles()
    {
        $expire = Carbon::now()->addMinutes(300); // 5 menit
        $select = Cache::remember('roles', $expire, function () {
            return Role::select(['id', 'name'])->orderBy('created_at', 'ASC')->get();
        });
        return $select;
    }
}

if (!function_exists('strip_tags_content')) {
    function strip_tags_content($string)
    {
        return strip_tags(html_entity_decode($string));
    }
}

if (!function_exists('tampil_aset')) {
    function tampil_aset($aset)
    {
        if (!trim($aset)) {
            return '';
        }

        $array = json_decode($aset);
        $str = '';
        if ($array) {
            foreach ($array as $r) {
                $baca = get_referensi($r);
                $str .= $baca . ", ";
            }
        }
        return $str ? rtrim($str, ", ") : '';
    }
}

if (!function_exists('status_pembayaran')) {
    function status_pembayaran($status = 0)
    {
        if (!$status) {
            return '<span class="badge badge-danger">Belum Lunas!</span>';
        } else {
            return '<span class="badge badge-success">Telah Lunas.</span>';
        }
    }
}

if (!function_exists('list_dokumen_upload')) {
    function list_dokumen_upload($keberadaan_ortu = NULL, $biaya = NULL): array
    {
        $dokumen[] = [
            'urutan' => 'label',
            'keterangan' => 'Calon Mahasiswa/i'
        ];

        $urutan = 1;
        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'ktp',
            'detail' => 'KTP Calon Mahasiswa/i',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'surat-pernyataan',
            'detail' => 'Surat Pernyataan Mahasiswa Persetujuan Penetapan Kelompok UKT. Format Surat <a href="' . route('frontend.download') . '" target="_blank" style="color:red"><u>[ Unduh disini ]</u></a>',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'formulit-ukt',
            'detail' => 'Scan Semua Halaman Formulir UKT dan Sudah Ditandatangani',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => 'label',
            'keterangan' => 'Sekolah'
        ];

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'ijazah',
            'detail' => 'Scan Ijazah / SKL bagi lulusan ' . date('Y') . ' / Surat Keterangan Mengikuti UTBK ' . date('Y') . ' Dari Sekolah',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => 'label',
            'keterangan' => 'Penanggung Biaya Pendidikan'
        ];
        // keberadaan ortu Ayah/Ibu Meninggal || Ayah Dan Ibu Meninggal
        if (isset($keberadaan_ortu) && in_array($keberadaan_ortu, ['c5a22644-5ac0-429a-9d61-feaa5f835559', 'f7d7586b-03aa-422f-816b-d54ea202edd3'])) {
            $dokumen[] = [
                'urutan' => $urutan,
                'dokumen' => 'surat-keterangan-meninggal',
                'detail' => 'Scan Surat Keterangan Dari Kelurahan, Keberadaan Orang Tua Bila Telah Meninggal Dunia',
                'wajib' => 'Y'
            ];
            $urutan++;
        }

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kartu-keluarga',
            'detail' => 'Scan Kartu Keluarga',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => 'label',
            'keterangan' => 'Penghasilan Keluarga'
        ];

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'surat-keterangan-penghasilan-ayah',
            'detail' => 'Scan Slip Gaji / Surat Keterangan Penghasilan Dari Kelurahan Penghasilan Ayah',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'surat-keterangan-penghasilan-ibu',
            'detail' => 'Scan Slip Gaji / Surat Keterangan Penghasilan Dari Kelurahan Penghasilan Ibu',
            'wajib' => 'Y'
        ];
        $urutan++;

        // biaya stydi dari wali
        if (isset($biaya) && $biaya == 'd7b7a055-fc2e-4e89-af3d-e0572bc601d3') {
            $dokumen[] = [
                'urutan' => $urutan,
                'dokumen' => 'surat-keterangan-penghasilan-wali',
                'detail' => 'Scan Slip Gaji / Surat Keterangan Penghasilan Dari Kelurahan Penghasilan Wali',
                'wajib' => 'Y'
            ];
            $urutan++;
        }

        // biaya stydi sendiri
        if (isset($biaya) && $biaya == '01076708-f0fc-4f39-af3b-7cae95ce96bc') {
            $dokumen[] = [
                'urutan' => $urutan,
                'dokumen' => 'surat-keterangan-penghasilan-sendiri',
                'detail' => 'Scan Slip Gaji / Surat Keterangan Penghasilan Dari Kelurahan Penghasilan Sendiri',
                'wajib' => 'Y'
            ];
            $urutan++;
        }

        $dokumen[] = [
            'urutan' => 'label',
            'keterangan' => 'Pengeluaran Keluarga'
        ];

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'rekening-listrik',
            'detail' => 'Scan Rekening Listrik',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => 'label',
            'keterangan' => 'Aset Rumah'
        ];

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'foto-rumah-tampak-depan',
            'detail' => 'Foto Rumah Tampak Depan (Foto Beserta Keluarga Di Depan Rumah)',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'foto-rumah-tampak-belakang',
            'detail' => 'Foto Rumah Tampak Belakang (Foto Beserta Keluarga Di Belakang Rumah)',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'foto-rumah-tampak-kiri',
            'detail' => 'Foto Rumah Tampak Kiri (Foto Beserta Keluarga Di Samping Kiri Rumah)',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'foto-rumah-tampak-kanan',
            'detail' => 'Foto Rumah Tampak Kanan (Foto Beserta Keluarga Di Samping Kanan Rumah)',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'foto-ruang-makan-dapur',
            'detail' => 'Foto Ruang Makan / Dapur Rumah (Foto Beserta Keluarga DI Dapur)',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'foto-ruang-tamu',
            'detail' => 'Foto Ruang Tamu (Foto Beserta Keluarga Dalam Ruang Tamu)',
            'wajib' => 'Y'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => 'label',
            'keterangan' => 'Berkas Dukung Lainnya'
        ];

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'rekening-beasiswa',
            'detail' => 'Scan Rekening Beasiswa',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kip',
            'detail' => 'Scan Kartu Indonesia Pintar / KIP',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kps',
            'detail' => 'Scan Kartu Perlindungan Sosial',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kjkm',
            'detail' => 'Scan Kartu Jaminan Kesehatan Masyarakat',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kkm',
            'detail' => 'Scan Kartu Keluarga Miskin',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kbm',
            'detail' => 'Scan Kartu Beras Miskin / Raskin',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kblt',
            'detail' => 'Scan Kartu Bantuan Langsung Tunai',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kph',
            'detail' => 'Scan Kartu Program Harapan',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kbsm',
            'detail' => 'Scan Kartu Bantuan Siswa Miskin',
            'wajib' => 'N'
        ];
        $urutan++;

        $dokumen[] = [
            'urutan' => $urutan,
            'dokumen' => 'kis',
            'detail' => 'Scan Kartu Indonesia Sehat',
            'wajib' => 'N'
        ];
        $urutan++;

        return $dokumen;
    }
}
