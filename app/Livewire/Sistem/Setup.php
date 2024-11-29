<?php

namespace App\Livewire\Sistem;

use App\Models\Setup as ModelsSetup;
use Livewire\Attributes\On;
use Livewire\Component;

class Setup extends Component
{
    public $judul = "Setup Pengimputan";

    public $id;
    public $tahun_add;
    public $tahun;
    public $registrasi_snbp;
    public $pengisian_snbp;
    public $pembayaran_snbp;

    public $registrasi_snbt;
    public $pengisian_snbt;
    public $pembayaran_snbt;

    public $registrasi_mandiri;
    public $pengisian_mandiri;
    public $pembayaran_mandiri;

    public $aktif;
    public $tampil = false;

    public function mount()
    {
        $this->tahun_add = date('Y');
        $setup = ModelsSetup::where('tampil', 1)->first();
        if ($setup) {
            $this->id = $setup->id;
            $this->tahun = $setup->tahun;
            $this->registrasi_snbp = $setup->registrasi_snbp;
            $this->pengisian_snbp = $setup->pengisian_snbp;
            $this->pembayaran_snbp = $setup->pembayaran_snbp;

            $this->registrasi_snbt = $setup->registrasi_snbt;
            $this->pengisian_snbt = $setup->pengisian_snbt;
            $this->pembayaran_snbt = $setup->pembayaran_snbt;

            $this->registrasi_mandiri = $setup->registrasi_mandiri;
            $this->pengisian_mandiri = $setup->pengisian_mandiri;
            $this->pembayaran_mandiri = $setup->pembayaran_mandiri;

            $this->aktif = $setup->aktif;
        }
    }

    public function render()
    {
        $listtahun = ModelsSetup::select(['tahun', 'tampil'])->orderBy('tahun', 'DESC')->get();
        $data = [
            'listtahun' => $listtahun
        ];

        return view('livewire.sistem.setup', $data)
            ->extends('layouts.backend')
            ->section('content');
    }

    #[On('tampilkan-setup')]
    public function tampilkan($tahun)
    {
        ModelsSetup::where('tahun', '>', 1)->update(['tampil' => false]);
        ModelsSetup::where('tahun', $tahun)->update(['tampil' => true]);
        $this->redirect(route('admin.setup'));
    }

    public function savetahun()
    {
        $this->validate([
            'tahun_add' => 'required|digits:4|numeric|min:2022|max:' . (date('Y') + 1) . '|unique:app_setup,tahun'
        ]);

        if ($this->tampil) {
            ModelsSetup::where('tahun', '>', 1)->update(['tampil' => false]);
        }

        ModelsSetup::create([
            'tahun' => $this->tahun_add,
            'tampil' => $this->tampil
        ]);
        alert()->success('Success', 'Tahun berhasil ditambahkan.');
        $this->redirect(route('admin.setup'));
    }

    public function updatesetup()
    {
        $this->validate([
            'registrasi_snbp' => 'required',
            'pengisian_snbp' => 'required',
            'pembayaran_snbp' => 'required',

            // 'registrasi_snbt' => 'required',
            // 'pengisian_snbt' => 'required',
            // 'pembayaran_snbt' => 'required',

            // 'registrasi_mandiri' => 'required',
            // 'pengisian_mandiri' => 'required',
            // 'pembayaran_mandiri' => 'required',
        ]);

        if ($this->aktif == 'Y') {
            // dd($this->aktif);
            ModelsSetup::where('tahun', '>', 1)->update(['aktif' => 'N']);
        }

        ModelsSetup::where('id', $this->id)->update([
            'registrasi_snbp' => $this->registrasi_snbp,
            'pengisian_snbp' => $this->pengisian_snbp,
            'pembayaran_snbp' => $this->pembayaran_snbp,

            'registrasi_snbt' => $this->registrasi_snbt,
            'pengisian_snbt' => $this->pengisian_snbt,
            'pembayaran_snbt' => $this->pembayaran_snbt,

            'registrasi_mandiri' => $this->registrasi_mandiri,
            'pengisian_mandiri' => $this->pengisian_mandiri,
            'pembayaran_mandiri' => $this->pembayaran_mandiri,
            'aktif' => $this->aktif,
        ]);
        $this->redirect(route('admin.setup'));
    }

    public function _reset()
    {
        $this->resetErrorBag();
        $this->tahun_add = date('Y');
        $this->tampil = false;
        $this->dispatch('close-modal');
    }
}
