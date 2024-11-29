<?php

namespace App\Livewire\Pesertaukt;

use App\Models\PesertauktPembiayaanStudi;
use Livewire\Component;

class Pembiayaanstudi extends Component
{
    public $judul = "Formulir UKT";
    public $subjudul = "Pembiayaan Studi";

    public PesertauktPembiayaanStudi $model;

    public $biaya_studi, $pekerjaan_sendiri, $detail_pekerjaan_sendiri, $pangkat_sendiri, $lahan_sendiri, $aset_sendiri, $aset_lainnya, $penghasilan_sendiri;
    public $wali, $pekerjaan_wali, $pangkat_wali, $lahan_wali, $aset_wali, $aset_wali_lainnya, $penghasilan_wali;

    public function mount()
    {
        $this->model = PesertauktPembiayaanStudi::with('peserta')->where('peserta_id', session('peserta_id'))->first();

        if (!$this->model->peserta->update_kondisi_keluarga) {
            alert()->error('Error', 'Silahkan lengkapi Formulir Kondisi Keluarga!');
            return $this->redirect(route('peserta.kondisikeluarga'));
        }

        $this->biaya_studi = $this->model->biaya_studi;
        $this->pekerjaan_sendiri = $this->model->pekerjaan_sendiri;
        $this->detail_pekerjaan_sendiri = $this->model->detail_pekerjaan_sendiri;
        $this->pangkat_sendiri = $this->model->pangkat_sendiri;
        $this->lahan_sendiri = $this->model->lahan_sendiri;
        $this->aset_sendiri = $this->model->aset_sendiri ? json_decode($this->model->aset_sendiri, true) : [];
        $this->aset_lainnya = $this->model->aset_lainnya;
        $this->penghasilan_sendiri = 'Rp. ' . rupiah($this->model->penghasilan_sendiri);

        $this->wali = $this->model->wali;
        $this->pekerjaan_wali = $this->model->pekerjaan_wali;
        $this->pangkat_wali = $this->model->pangkat_wali;
        $this->lahan_wali = $this->model->lahan_wali;
        $this->aset_wali = $this->model->aset_wali  ? json_decode($this->model->aset_wali, true) : [];
        $this->aset_wali_lainnya = $this->model->aset_wali_lainnya;
        $this->penghasilan_wali = 'Rp. ' . rupiah($this->model->penghasilan_wali);
    }

    public function render()
    {
        $get_status = auth()->user()->status_peserta();
        $akses_formulir = auth()->user()->akses_formulirukt();
        if (!in_array($get_status, [null, 1, 2]) || !$akses_formulir) {
            abort(403);
            exit();
        }

        return view('livewire.pesertaukt.pembiayaanstudi')
            ->extends('layouts.backend')
            ->section('content');
    }

    public function save()
    {
        $this->validate([
            'biaya_studi' => 'required'
        ]);

        $this->model->peserta->update([
            'status' => '1',
            'update_pembiayaan_studi' => true
        ]);

        $this->model->update([
            'biaya_studi' => $this->biaya_studi,
            'pekerjaan_sendiri' => $this->pekerjaan_sendiri,
            'detail_pekerjaan_sendiri' => $this->detail_pekerjaan_sendiri,
            'pangkat_sendiri' => $this->pangkat_sendiri,
            'lahan_sendiri' => $this->lahan_sendiri,
            'aset_sendiri' => json_encode($this->aset_sendiri),
            'aset_lainnya' => $this->aset_lainnya,
            'penghasilan_sendiri' => rupiah($this->penghasilan_sendiri, false),

            'wali' => $this->wali,
            'pekerjaan_wali' => $this->pekerjaan_wali,
            'pangkat_wali' => $this->pangkat_wali,
            'lahan_wali' => $this->lahan_wali,
            'aset_wali' => json_encode($this->aset_wali),
            'aset_wali_lainnya' => $this->aset_wali_lainnya,
            'penghasilan_wali' => rupiah($this->penghasilan_wali, false)
        ]);

        alert()->success('Success', 'Data Formulir UKT Telah Tersimpan, Selanjutnya Silahkan Cetak Formulir UKT dan Upload Berkas Dukung!');
        return $this->redirect(route('peserta.pembiayaanstudi'));
    }
}
