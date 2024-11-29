<?php

namespace App\Http\Controllers;

use App\Models\Pesertaukt;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class PDF extends Fpdf
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Title', 1, 0, 'C');
        $this->Ln(0);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
    }
}

class PDFL extends Fpdf
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        //Geser ke kanan
        $this->Cell(80);
        //Judul dalam bingkai
        $this->Cell(30, 10, 'Title', 1, 0, 'C');
        //Ganti baris
        $this->Ln(0);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
    }
}

class CetakController extends Controller
{
    public function formverifikator($params)
    {
        $params = decode_arr($params);
        if (!$params) {
            abort(403);
        }
        $peserta = Pesertaukt::with(['setup', 'fakultas', 'prodi'])->where('id', $params['peserta_id'])->first();
        $pdf = new PDF('P', 'cm', 'legal');

        $pdf->isFinished = false;

        $pdf->AddPage();
        $thn = $peserta->setup->tahun;
        // $pdf->SetTitle('Formulir UKT - '.$peserta->nama_peserta);

        $pdf->Image(public_path('images/dikbud.jpg'), 2, 0.5, 2, 2.2);
        $pdf->Image(public_path('images/logo.jpg'), 17, 0.5, 2, 2.2);
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(19, 0.5, 'KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI', '', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.5, 'UNIVERSITAS KHAIRUN', '', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont("Arial", "", 10);
        $pdf->Cell(19, 0.5, 'Kampus II Kelurahan Gambesi Kota Ternate Selatan', '', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.5, 'Telp. 0921-3110905, Fax (0921) 3110901 Kotak Pos 53 Ternate 97719', '', 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(19, 0.5, 'FORMULIR VERIFIKASI UKT', '', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.5, 'SUMBER PENERIMAAN : SNBP / SNBT / SELEKSI MANDIRI ' . $thn, '', 0, 'C');
        $pdf->Ln();
        $pdf->line(20, 3, 1, 3);
        $pdf->Ln();
        $pdf->Ln();


        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(1, 0.5, 'I', 'LT', 0, 'C');
        $pdf->Cell(17.5, 0.5, 'DATA DIRI', 'RT', 0, 'C');
        $pdf->Ln();

        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(1, 0.5, '1', 'LT', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nama Lengkap', 'T', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->nama_peserta)), 'TR', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '2', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Jenis Kelamin', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(($peserta->jk == 'L') ? 'Laki-Laki' : 'Perempuan')), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '3', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Agama', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . $peserta->agama, 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '4', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tempat Lahir', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->tpl_lahir)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '5', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tanggal Lahir', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . $peserta->tgl_lahir, 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '6', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'NIK', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->nik)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '7', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tahun Ijazah/Tahun Lulus SLTA', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->thn_lulus)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lapirkan Ijazah/Surat Keterangan Lulus)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '8', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nomor Peserta', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->nomor_peserta)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '9', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Jenis Peserta Bidikmisi', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(($peserta->kip) ? 'Bidikmisi' : 'Bukan Bidikmisi')), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '10', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Fakultas', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->fakultas->nama_fakultas)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '11', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Program Studi', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->prodi->jenjang_prodi . ' - ' . $peserta->prodi->nama_prodi)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '12', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Alamat Asal', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->alamat_asal)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '13', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Alamat DI Ternate', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->alamat_tte)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '14', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nomor Hp Mahasiswa', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->hp)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '15', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nomor Hp Orang Tua/Wali', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->hportu)), 'R', 0, 'L');
        $pdf->Ln();


        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(1, 0.5, 'II', 'LT', 0, 'C');
        $pdf->Cell(17.5, 0.5, 'KONDISI KELUARGA', 'RT', 0, 'C');
        $pdf->Ln();

        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(1, 0.5, '1', 'LT', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nama Orang Tua / Wali', 'T', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'TR', 0, 'L');
        $pdf->Ln();

        $keluarga = $peserta->kondisikeluarga;

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->nama_ayah)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->nama_ibu)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Wali', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->nama_wali)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '2', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Keberadaan Orang Tua', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->keberadaan_ortu))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Bila Telah Meninggal Lampirkan Surat Keterangan Kematian Dari Kelurahan)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '3', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Jumlah Kakak dan Adik', '', 0, 'L');
        $pdf->Cell(3, 0.5, ': Kakak : ' . $keluarga->jml_kakak . ' Orang', '', 0, 'L');
        $pdf->Cell(7.5, 0.5, 'Adik : ' . $keluarga->jml_adik . ' Orang', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lampirkan Kartu Keluarga)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '4', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tanggungan Pendidikan', '', 0, 'L');
        $pdf->Cell(3, 0.5, ': Sekolah : ' . $keluarga->jml_sekolah . ' Orang', '', 0, 'L');
        $pdf->Cell(7.5, 0.5, 'Kuliah : ' . $keluarga->jml_kuliah . ' Orang', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '5', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Pekerjaan Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . get_referensi($keluarga->pekerjaan_ayah), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Pangkat, Golongan Dan Jabatan Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->pangkat_ayah)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Penghasilan Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': Rp. ' . number_format($keluarga->penghasilan_ayah), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lampirkan Slip Gaji / Keterangan Kelurahan)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '5', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Pekerjaan Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . get_referensi($keluarga->pekerjaan_ibu), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Pangkat, Golongan Dan Jabatan Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->pangkat_ibu)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Penghasilan Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': Rp. ' . number_format($keluarga->penghasilan_ibu), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lampirkan Slip Gaji / Keterangan Kelurahan)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '7', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Lahan Yang Dimiliki Dan Luasannya', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->luas_lahan))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '8', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Aset Yang Dimiliki Untuk Menunjang Usaha', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . tampil_aset($keluarga->aset_ortu), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '9', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Kepemilikan Rumah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->kepemilikan_rumah))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '10', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Kondisi Rumah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->kondisi_rumah))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lapirkan Foto Rumah Tampak Depan, Kiri, Kanan & Belakang)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '11', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Lokasi Tempat Tinggal', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->lokasi_rumah))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '12', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Daya Listrik (Lampirkan slip Rekening)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->daya_listrik))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '13', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Bantuan Siswa Miskin (SMA/SMK/MA)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->bantuan_siswa_miskin))), 'R', 0, 'L');
        $pdf->Ln();


        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(1, 0.5, 'II', 'LT', 0, 'C');
        $pdf->Cell(17.5, 0.5, 'PEMBIAYAAN STUDI / KULIAH OLEH', 'RT', 0, 'C');
        $pdf->Ln();

        $biaya = $peserta->pembiayaanstudi;

        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(1, 0.5, '1', 'LT', 0, 'C');
        $pdf->Cell(7, 0.5, 'Pembiayaan Studi Oleh', 'T', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower('Biaya ' . get_referensi($biaya->biaya_studi))), 'TR', 0, 'L');

        if (get_referensi($biaya->biaya_studi) == 'Wali') {
            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Bila Pembiayaan Kuliah Dibiayai Oleh Wali. lanjutkan ke pertanyaan berikut :', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
            $pdf->Ln();

            $pdf->SetFont("Arial", "", 9);
            $pdf->Cell(1, 0.5, '2', 'LT', 0, 'C');
            $pdf->Cell(7, 0.5, 'Wali', 'T', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($biaya->wali))), 'TR', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '3', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Pekerjaan Wali', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . get_referensi($biaya->pekerjaan_wali), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Pangkat, Golongan Dan Jabatan', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($biaya->pangkat_wali)), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Lahan Yang Dimiliki Dan Luasannya', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($biaya->lahan_wali)), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Aset Yang Dimiliki Untuk Menunjang Usaha', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . tampil_aset($biaya->aset_wali) . (trim($biaya->aset_wali_lainnya) ? ', ' . $biaya->aset_wali_lainnya : ''), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '4', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Penghasilan Wali', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': Rp. ' . ucwords(strtolower(number_format($biaya->penghasilan_wali))), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '(Lampirkan Slip Gaji / Keterangan Kelurahan)', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
            $pdf->Ln();
        }

        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();

        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(18.5, 0.5, 'INFORMASI TAMBAHAN DAN REKOMENDASI PEWAWANCARA :', 'RLBT', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, 'Informasi Tambahan : ', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, 'Rekomendasi Pewawancara : ', 'LTR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LBR', 0, 'L');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 9);
        $tanggal = date("Y-m-d");
        $tgll = 'Ternate, ' . tgl_indo($tanggal, false);

        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(12.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(6.3, 0.5, $tgll, 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(10, 0.5, 'Orang Tua/Wali Calon Mahasiswa', '', 0, 'L');
        $pdf->Cell(6.3, 0.5, 'Pewawancara', 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();

        $pewawancara = $peserta->verifikasiberkas?->verifikator?->name ?? '-';

        $pdf->Cell(2.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(10, 0.5, '(....................................)', '', 0, 'L');
        $pdf->Cell(3.3, 0.5, $pewawancara, '', 0, 'L');
        $pdf->Cell(3, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(10, 0.5, '', '', 0, 'L');
        $pdf->Cell(3.3, 0.5, 'NIP. ', '', 0, 'L');
        $pdf->Cell(3, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LBR', 0, 'L');

        $pdf->isFinished = true;

        $jud = 'Formulir UKT - ' . $peserta->nama_peserta;

        //menampilkan output beupa halaman PDF
        $pdf->Output($jud, 'D');
        exit();
    }

    public function formulirukt($params)
    {
        $params = decode_arr($params);
        if (!$params) {
            abort(403);
        }

        // dd($params);
        $peserta = Pesertaukt::with(['setup', 'fakultas', 'prodi'])->where('id', $params['peserta_id'])->first();
        $pdf = new PDF('P', 'cm', 'legal');

        $pdf->isFinished = false;

        $pdf->AddPage();
        $thn = $peserta->setup->tahun;
        // $pdf->SetTitle('Formulir UKT - '.$peserta->nama_peserta);

        $pdf->Image(public_path('images/dikbud.jpg'), 2, 0.5, 2, 2.2);
        $pdf->Image(public_path('images/logo.jpg'), 17, 0.5, 2, 2.2);
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(19, 0.5, 'KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI', '', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.5, 'UNIVERSITAS KHAIRUN', '', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont("Arial", "", 10);
        $pdf->Cell(19, 0.5, 'Kampus II Kelurahan Gambesi Kota Ternate Selatan', '', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.5, 'Telp. 0921-3110905, Fax (0921) 3110901 Kotak Pos 53 Ternate 97719', '', 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont("Arial", "B", 10);
        $pdf->Cell(19, 0.5, 'FORMULIR VERIFIKASI UKT', '', 0, 'C');
        $pdf->Ln();
        $pdf->Cell(19, 0.5, 'SUMBER PENERIMAAN : SNBP / SNBT / SELEKSI MANDIRI ' . $thn, '', 0, 'C');
        $pdf->Ln();
        $pdf->line(20, 3, 1, 3);
        $pdf->Ln();
        $pdf->Ln();


        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(1, 0.5, 'I', 'LT', 0, 'C');
        $pdf->Cell(17.5, 0.5, 'DATA DIRI', 'RT', 0, 'C');
        $pdf->Ln();

        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(1, 0.5, '1', 'LT', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nama Lengkap', 'T', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->nama_peserta)), 'TR', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '2', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Jenis Kelamin', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(($peserta->jk == 'L') ? 'Laki-Laki' : 'Perempuan')), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '3', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Agama', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . $peserta->agama, 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '4', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tempat Lahir', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->tpl_lahir)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '5', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tanggal Lahir', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->tgl_lahir)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '6', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'NIK', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->nik)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '7', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tahun Ijazah/Tahun Lulus SLTA', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->thn_lulus)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lapirkan Ijazah/Surat Keterangan Lulus)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '8', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nomor Peserta', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->nomor_peserta)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '9', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Jenis Peserta Bidikmisi', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(($peserta->kip) ? 'Bidikmisi' : 'Bukan Bidikmisi')), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '10', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Fakultas', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->fakultas->nama_fakultas)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '11', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Program Studi', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->prodi->jenjang_prodi . ' - ' . $peserta->prodi->nama_prodi)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '12', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Alamat Asal', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->alamat_asal)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '13', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Alamat DI Ternate', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->alamat_tte)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '14', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nomor Hp Mahasiswa', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->hp)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '15', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nomor Hp Orang Tua/Wali', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($peserta->hportu)), 'R', 0, 'L');
        $pdf->Ln();


        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(1, 0.5, 'II', 'LT', 0, 'C');
        $pdf->Cell(17.5, 0.5, 'KONDISI KELUARGA', 'RT', 0, 'C');
        $pdf->Ln();

        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(1, 0.5, '1', 'LT', 0, 'C');
        $pdf->Cell(7, 0.5, 'Nama Orang Tua / Wali', 'T', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'TR', 0, 'L');
        $pdf->Ln();

        $keluarga = $peserta->kondisikeluarga;

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->nama_ayah)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->nama_ibu)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Wali', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->nama_wali)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '2', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Keberadaan Orang Tua', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->keberadaan_ortu))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Bila Telah Meninggal Lampirkan Surat Keterangan Kematian Dari Kelurahan)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '3', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Jumlah Kakak dan Adik', '', 0, 'L');
        $pdf->Cell(3, 0.5, ': Kakak : ' . $keluarga->jml_kakak . ' Orang', '', 0, 'L');
        $pdf->Cell(7.5, 0.5, 'Adik : ' . $keluarga->jml_adik . ' Orang', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lampirkan Kartu Keluarga)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '4', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Tanggungan Pendidikan', '', 0, 'L');
        $pdf->Cell(3, 0.5, ': Sekolah : ' . $keluarga->jml_sekolah . ' Orang', '', 0, 'L');
        $pdf->Cell(7.5, 0.5, 'Kuliah : ' . $keluarga->jml_kuliah . ' Orang', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '5', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Pekerjaan Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . get_referensi($keluarga->pekerjaan_ayah), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Pangkat, Golongan Dan Jabatan Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->pangkat_ayah)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Penghasilan Ayah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': Rp. ' . number_format($keluarga->penghasilan_ayah), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lampirkan Slip Gaji / Keterangan Kelurahan)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '5', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Pekerjaan Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . get_referensi($keluarga->pekerjaan_ibu), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Pangkat, Golongan Dan Jabatan Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($keluarga->pangkat_ibu)), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '* Penghasilan Ibu', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': Rp. ' . number_format($keluarga->penghasilan_ibu), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lampirkan Slip Gaji / Keterangan Kelurahan)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '7', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Lahan Yang Dimiliki Dan Luasannya', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->luas_lahan))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '8', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Aset Yang Dimiliki Untuk Menunjang Usaha', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . tampil_aset($keluarga->aset_ortu), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '9', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Kepemilikan Rumah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->kepemilikan_rumah))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '10', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Kondisi Rumah', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->kondisi_rumah))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, '(Lapirkan Foto Rumah Tampak Depan, Kiri, Kanan & Belakang)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '11', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Lokasi Tempat Tinggal', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->lokasi_rumah))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '12', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Daya Listrik (Lampirkan slip Rekening)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->daya_listrik))), 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(1, 0.5, '13', 'L', 0, 'C');
        $pdf->Cell(7, 0.5, 'Bantuan Siswa Miskin (SMA/SMK/MA)', '', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($keluarga->bantuan_siswa_miskin))), 'R', 0, 'L');
        $pdf->Ln();


        $pdf->SetFont("Arial", "B", 9);
        $pdf->Cell(1, 0.5, 'II', 'LT', 0, 'C');
        $pdf->Cell(17.5, 0.5, 'PEMBIAYAAN STUDI / KULIAH OLEH', 'RT', 0, 'C');
        $pdf->Ln();

        $biaya = $peserta->pembiayaanstudi;

        $pdf->SetFont("Arial", "", 9);
        $pdf->Cell(1, 0.5, '1', 'LT', 0, 'C');
        $pdf->Cell(7, 0.5, 'Pembiayaan Studi Oleh', 'T', 0, 'L');
        $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower('Biaya ' . get_referensi($biaya->biaya_studi))), 'TR', 0, 'L');

        if (get_referensi($biaya->biaya_studi) == 'Wali') {
            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Bila Pembiayaan Kuliah Dibiayai Oleh Wali. lanjutkan ke pertanyaan berikut :', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
            $pdf->Ln();

            $pdf->SetFont("Arial", "", 9);
            $pdf->Cell(1, 0.5, '2', 'LT', 0, 'C');
            $pdf->Cell(7, 0.5, 'Wali', 'T', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($biaya->wali))), 'TR', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '3', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Pekerjaan Wali', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . get_referensi($biaya->pekerjaan_wali), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Pangkat, Golongan Dan Jabatan', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($biaya->pangkat_wali)), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Lahan Yang Dimiliki Dan Luasannya', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($biaya->lahan_wali)), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Aset Yang Dimiliki Untuk Menunjang Usaha', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . tampil_aset($biaya->aset_wali) . (trim($biaya->aset_wali_lainnya) ? ', ' . $biaya->aset_wali_lainnya : ''), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '4', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Penghasilan Wali', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': Rp. ' . ucwords(strtolower(number_format($biaya->penghasilan_wali))), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '(Lampirkan Slip Gaji / Keterangan Kelurahan)', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
            $pdf->Ln();
        } elseif (get_referensi($biaya->biaya_studi) == 'Sendiri') {
            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Bila Pembiayaan Kuliah Dibiayai Oleh Sendiri. lanjutkan ke pertanyaan berikut :', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '2', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Pekerjaan Sendiri', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . get_referensi($biaya->pekerjaan_sendiri) . (trim($biaya->detail_pekerjaan_sendiri) ? ', ' . $biaya->detail_pekerjaan_sendiri : ''), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Pangkat, Golongan Dan Jabatan', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower($biaya->pangkat_sendiri)), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Lahan Yang Dimiliki Dan Luasannya', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . ucwords(strtolower(get_referensi($biaya->pekerjaan_sendiri))), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '* Aset Yang Dimiliki Untuk Menunjang Usaha', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': ' . tampil_aset($biaya->aset_wali), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '3', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, 'Penghasilan Sendiri', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, ': Rp. ' . ucwords(strtolower($biaya->penghasilan_sendiri)), 'R', 0, 'L');
            $pdf->Ln();

            $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
            $pdf->Cell(7, 0.5, '(Lampirkan Slip Gaji Sendiri / Keterangan Kelurahan)', '', 0, 'L');
            $pdf->Cell(10.5, 0.5, '', 'R', 0, 'L');
            $pdf->Ln();
        }


        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(1, 0.5, '', 'L', 0, 'C');
        $pdf->Cell(17.5, 0.5, 'Data yang kami berikan ini adalah benar, dan apabila ada kesalahan pada data ini, kami siap bertanggung jawab.', 'R', 0, 'L');


        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 9);
        $tanggal = date("Y-m-d");
        $tgll = 'Ternate, ' . tgl_indo($tanggal, false);

        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(12.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(6.3, 0.5, $tgll, 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(10, 0.5, 'Orang Tua/Wali Calon Mahasiswa', '', 0, 'L');
        $pdf->Cell(6.3, 0.5, 'Calon Mahasiswa/i', 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(10, 0.5, '       Materai 10.000', '', 0, 'L');
        $pdf->Cell(6.3, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();

        $csiswa = ucwords(strtolower($peserta->nama_peserta));

        $pdf->Cell(2.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(10, 0.5, '(....................................)', '', 0, 'L');
        $pdf->Cell(3.3, 0.5, '(' . $csiswa . ')', '', 0, 'L');
        $pdf->Cell(3, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(2.2, 0.5, '', 'L', 0, 'L');
        $pdf->Cell(10, 0.5, '', '', 0, 'L');
        $pdf->Cell(3.3, 0.5, '', '', 0, 'L');
        $pdf->Cell(3, 0.5, '', 'R', 0, 'L');
        $pdf->Ln();

        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, 'Keterangan :', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '- Uang Kuliah Tunggal (UKT) pengelompokan pembiayaan kuliah berdasarkan kelompok kemampuan ekonomi masyarakat', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '- Pembayaran Uang Kuliah Tunggal (UKT) maka mahasiswa terbebas dari biaya sbb :', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '  * Biaya Registrasi Ulang Setiap Semester', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '  * Biaya Perpustakaan', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '  * Biaya Kubermas', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '  * Biaya Seminar Proposal, Skripsi, KP, Seminar Hasil', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '  * Biaya Wisuda', 'LR', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(18.5, 0.5, '', 'LBR', 0, 'L');
        $pdf->Ln();

        $pdf->isFinished = true;

        $jud = 'Formulir UKT - ' . $peserta->nama_peserta;

        //menampilkan output beupa halaman PDF
        if ($params['output'] == 'D') {
            $pdf->Output($jud, 'D');
        } else {
            $pdf->Output($jud, 'I');
        }
        exit();
    }
}
