<?php

namespace App\Livewire\Master;

use App\Models\ProdiBiayastudi;
use Livewire\Component;

class Biayaipi extends Component
{
    public $listdata = [];

    public $lable = "Tambah Biaya IPI";

    public $id;
    public $mode = 'add';
    public $prodi_id;
    public $kategori_ipi;
    public $nominal_ipi;

    public function mount($prodi_id)
    {
        $this->prodi_id = $prodi_id;
        $this->listdata = ProdiBiayastudi::byprodi($prodi_id)->jenisbiaya('ipi')->orderBy('kategori', 'ASC')->get();
    }
    public function render()
    {
        return view('livewire.master.biayaipi');
    }

    public function add()
    {
        $this->kategori_ipi = "";
        $this->nominal_ipi = "";

        $this->resetErrorBag();
        $this->dispatch('open-modal', modal: 'ModalIPI');
    }

    public function edit($id)
    {
        $get = ProdiBiayastudi::where('id', $id)->first();
        $this->mode = 'edit';
        $this->id = $id;
        $this->kategori_ipi = $get->kategori;
        $this->nominal_ipi = 'Rp. ' . rupiah($get->nominal);
        $this->lable = "Edith Biaya IPI";
        $this->dispatch('open-modal', modal: 'ModalIPI');
    }

    public function save()
    {
        $this->validate([
            'kategori_ipi' => 'required',
            'nominal_ipi' => 'required',
        ]);

        //dd($this);

        if ($this->mode == 'add') {
            ProdiBiayastudi::updateOrCreate([
                'prodi_id' => $this->prodi_id,
                'jenis_biaya' => 'ipi',
                'kategori' => $this->kategori_ipi
            ], [
                'prodi_id' => $this->prodi_id,
                'jenis_biaya' => 'ipi',
                'nominal' => rupiah($this->nominal_ipi, false),
                'kategori' => $this->kategori_ipi
            ]);
        } else {
            ProdiBiayastudi::where('id', $this->id)->update([
                'nominal' => rupiah($this->nominal_ipi, false),
                'kategori' => $this->kategori_ipi
            ]);
        }

        $this->mount($this->prodi_id);

        $this->dispatch('alert', type: 'success', message: 'Biaya IPI Berhasil Disimpan.');
        $this->dispatch('close-modal', modal: 'ModalIPI');
    }

    public function hapus($id)
    {
        ProdiBiayastudi::where('id', $id)->delete();

        $this->mount($this->prodi_id);
        $this->dispatch('alert', type: 'success', message: 'Biaya IPI Berhasil Dihapus.');
    }

    public function _reset()
    {
        $this->kategori_ipi = "";
        $this->nominal_ipi = "";

        $this->resetErrorBag();
        $this->dispatch('close-modal', modal: 'ModalIPI');
    }
}
