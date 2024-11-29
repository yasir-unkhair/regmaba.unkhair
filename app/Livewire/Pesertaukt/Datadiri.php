<?php

namespace App\Livewire\Pesertaukt;

use App\Models\Pesertaukt;
use Livewire\Component;

class Datadiri extends Component
{
    public $judul = "Formulir UKT";
    public $subjudul = "Data Diri";

    public Pesertaukt $model;

    public $id, $fakultas, $prodi, $nama_peserta, $jk, $golongan_darah, $agama, $tpl_lahir, $tgl_lahir, $nik, $thn_lulus, $nisn, $npsn, $sekolah_asal, $alamat_asal, $alamat_tte, $hp, $hportu, $kip, $update_data_diri, $status;

    public function mount()
    {

        $this->model = Pesertaukt::with(['fakultas', 'prodi', 'setup'])->where('id', session('peserta_id'))->first();
        // $this->model = $this->model->first();
        if ($this->model) {
            $this->id = $this->model->id;
            $this->fakultas = $this->model->fakultas?->nama_fakultas;
            $this->prodi = $this->model->prodi->kode_prodi . ' - ' . $this->model->prodi->nama_prodi;
            $this->nama_peserta = $this->model->nama_peserta;
            $this->jk = $this->model->jk;
            $this->golongan_darah = $this->model->golongan_darah;
            $this->agama = $this->model->agama;
            $this->tpl_lahir = $this->model->tpl_lahir;
            $this->tgl_lahir = $this->model->tgl_lahir;
            $this->nik = $this->model->nik;
            $this->thn_lulus = $this->model->thn_lulus;
            $this->nisn = $this->model->nisn;
            $this->npsn = $this->model->npsn;
            $this->sekolah_asal = $this->model->sekolah_asal;
            $this->alamat_asal = $this->model->alamat_asal;
            $this->alamat_tte = $this->model->alamat_tte;
            $this->hp = $this->model->hp;
            $this->hportu = $this->model->hportu;
            // $this->kip = $this->model->kip;
            $this->update_data_diri = $this->model->update_data_diri;
            $this->status = $this->model->status;
        }
    }
    public function render()
    {
        $this->model_status = auth()->user()->status_peserta();
        $akses_formulir = auth()->user()->akses_formulirukt();
        if (!in_array($this->model_status, [null, 1, 2]) || !$akses_formulir) {
            abort(403);
            exit();
        }

        return view('livewire.pesertaukt.datadiri')
            ->extends('layouts.backend')
            ->section('content');
    }

    public function save()
    {
        $this->validate([
            'nik' => ['required', 'digits:16', 'numeric'],
            'nama_peserta' => ['required'],
            'jk' => ['required'],
            'golongan_darah' => ['required'],
            'agama' => ['required'],
            'tpl_lahir' => ['required'],
            'tgl_lahir' => ['required'],
            'alamat_asal' => ['required'],
            'alamat_tte' => ['required', 'min:10', 'max:100'],
            'hp' => ['required', 'digits_between:10,12'],
            'hportu' => ['required', 'digits_between:10,12'],
            'thn_lulus' => ['required', 'digits:4', 'numeric'],
            'nisn' => ['required'],
            'npsn' => ['required'],
            'sekolah_asal' => ['required'],
        ]);

        $this->model->update([
            'nik' => $this->nik,
            'nama_peserta' => $this->nama_peserta,
            'jk' => $this->jk,
            'golongan_darah' => $this->golongan_darah,
            'agama' => $this->agama,
            'tpl_lahir' => $this->tpl_lahir,
            'tgl_lahir' => $this->tgl_lahir,
            'alamat_asal' => $this->alamat_asal,
            'alamat_tte' => $this->alamat_tte,
            'hp' => $this->hp,
            'hportu' => $this->hportu,
            'thn_lulus' => $this->thn_lulus,
            'nisn' => $this->nisn,
            'npsn' => $this->npsn,
            'sekolah_asal' => $this->sekolah_asal,
            'update_data_diri' => true,
            'status' => 1,
        ]);

        alert()->success('Success', 'Data Diri berhasil disimpan, Selanjutnya silahkan lengkapi form Kondisi Keluarga!');
        return $this->redirect(route('peserta.datadiri'));
    }
}
