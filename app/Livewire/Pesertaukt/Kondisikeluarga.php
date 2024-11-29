<?php

namespace App\Livewire\Pesertaukt;

use App\Models\PesertauktKondisiKeluarga;
use Livewire\Component;

class Kondisikeluarga extends Component
{
    public $judul = "Formulir UKT";
    public $subjudul = "Kondisi Keluarga";

    public PesertauktKondisiKeluarga $model;

    public $nama_ayah, $nama_ibu, $nama_wali, $keberadaan_ortu, $jml_kakak, $jml_adik, $jml_kuliah, $jml_sekolah;
    public $pekerjaan_ayah, $pangkat_ayah, $penghasilan_ayah, $pekerjaan_ibu, $pangkat_ibu, $penghasilan_ibu, $pebanding_penghasilan_ayah, $pebanding_penghasilan_ibu;
    public $luas_lahan, $kepemilikan_rumah, $kondisi_rumah, $lokasi_rumah, $daya_listrik, $bantuan_siswa_miskin;
    public $aset_ortu = NULL;

    public function mount()
    {
        $this->model = PesertauktKondisiKeluarga::with('peserta')->where('peserta_id', session('peserta_id'))->first();
        if (!$this->model->peserta->update_data_diri) {
            alert()->error('Error', 'Silahkan lengkapi Formulir Data Diri!');
            return $this->redirect(route('peserta.datadiri'));
        }

        if ($this->model) {
            $this->nama_ayah = $this->model->nama_ayah;
            $this->nama_ibu = $this->model->nama_ibu;
            $this->nama_wali = $this->model->nama_wali;
            $this->keberadaan_ortu = $this->model->keberadaan_ortu;
            $this->jml_kakak = $this->model->jml_kakak ? $this->model->jml_kakak : 0;
            $this->jml_adik = $this->model->jml_adik ? $this->model->jml_adik : 0;
            $this->jml_kuliah = $this->model->jml_kuliah ? $this->model->jml_kuliah : 0;
            $this->jml_sekolah = $this->model->jml_sekolah ? $this->model->jml_sekolah : 0;
            $this->pekerjaan_ayah = $this->model->pekerjaan_ayah;
            $this->pangkat_ayah = $this->model->pangkat_ayah;
            $this->penghasilan_ayah = 'Rp. ' . rupiah($this->model->penghasilan_ayah);
            $this->pekerjaan_ibu = $this->model->pekerjaan_ibu;
            $this->pangkat_ibu = $this->model->pangkat_ibu;
            $this->penghasilan_ibu = 'Rp. ' . rupiah($this->model->penghasilan_ibu);
            $this->pebanding_penghasilan_ayah = $this->model->pebanding_penghasilan_ayah;
            $this->luas_lahan = $this->model->luas_lahan;
            $this->aset_ortu = $this->model->aset_ortu ? json_decode($this->model->aset_ortu, true) : [];
            $this->kepemilikan_rumah = $this->model->kepemilikan_rumah;
            $this->kondisi_rumah = $this->model->kondisi_rumah;
            $this->lokasi_rumah = $this->model->lokasi_rumah;
            $this->daya_listrik = $this->model->daya_listrik;
            $this->bantuan_siswa_miskin = $this->model->bantuan_siswa_miskin;
        }
    }

    public function render()
    {
        $get_status = auth()->user()->status_peserta();
        $akses_formulir = auth()->user()->akses_formulirukt();
        if (!in_array($get_status, [null, 1, 2]) || !$akses_formulir) {
            abort(403);
            exit();
        }

        return view('livewire.pesertaukt.kondisikeluarga')
            ->extends('layouts.backend')
            ->section('content');
    }

    public function save()
    {
        $this->validate([
            'nama_ayah' => ['required'],
            'nama_ibu' => ['required'],
            'keberadaan_ortu' => ['required'],
            'jml_kakak' => ['required', 'numeric'],
            'jml_adik' => ['required', 'numeric'],
            'jml_kuliah' => ['required', 'numeric'],
            'jml_sekolah' => ['required', 'numeric'],
            'pekerjaan_ayah' => ['required'],
            'penghasilan_ayah' => ['required'],
            'pekerjaan_ibu' => ['required'],
            'penghasilan_ibu' => ['required'],
            'luas_lahan' => ['required'],
            'aset_ortu' => ['required', 'array', 'min:1'],
            'kepemilikan_rumah' => ['required'],
            'kondisi_rumah' => ['required'],
            'lokasi_rumah' => ['required'],
            'daya_listrik' => ['required'],
            'bantuan_siswa_miskin' => ['required'],
        ]);

        $this->model->peserta->update([
            'status' => '1',
            'update_kondisi_keluarga' => true
        ]);

        $this->model->update([
            'nama_ayah' => $this->nama_ayah,
            'nama_ibu' => $this->nama_ibu,
            'keberadaan_ortu' => $this->keberadaan_ortu,
            'jml_kakak' => $this->jml_kakak,
            'jml_adik' => $this->jml_adik,
            'jml_kuliah' => $this->jml_kuliah,
            'jml_sekolah' => $this->jml_sekolah,
            'pekerjaan_ayah' => $this->pekerjaan_ayah,
            'pangkat_ayah' => $this->pangkat_ayah,
            'penghasilan_ayah' => rupiah($this->penghasilan_ayah, false),
            'pekerjaan_ibu' => $this->pekerjaan_ibu,
            'pangkat_ibu' => $this->pangkat_ibu,
            'penghasilan_ibu' => rupiah($this->penghasilan_ibu, false),
            'luas_lahan' => $this->luas_lahan,
            'aset_ortu' => json_encode($this->aset_ortu),
            'kepemilikan_rumah' => $this->kepemilikan_rumah,
            'kondisi_rumah' => $this->kondisi_rumah,
            'lokasi_rumah' => $this->lokasi_rumah,
            'daya_listrik' => $this->daya_listrik,
            'bantuan_siswa_miskin' => $this->bantuan_siswa_miskin
        ]);

        alert()->success('Success', 'Formulir Kondisi Keluarga berhasil disimpan, Selanjutnya silahkan lengkapi formulir Pembiayaan Studi!');
        return $this->redirect(route('peserta.kondisikeluarga'));
    }
}
