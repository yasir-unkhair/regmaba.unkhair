<?php

namespace App\Livewire\Master;

use App\Livewire\Pesertaukt\Pembiayaanstudi;
use App\Models\ProdiBiayastudi;
use Livewire\Component;

class Biayaukt extends Component
{
    public $listdata = [];

    public $id;
    public $prodi_id;
    public $kategori_ukt;
    public $nominal_ukt;

    public function mount($prodi_id)
    {
        $this->prodi_id = $prodi_id;
        $this->listdata = ProdiBiayastudi::byprodi($prodi_id)->jenisbiaya('ukt')->orderBy('kategori', 'ASC')->get();
    }
    public function render()
    {
        return view('livewire.master.biayaukt');
    }

    public function edit($id)
    {
        $get = ProdiBiayastudi::where('id', $id)->first();
        $this->id = $id;
        $this->kategori_ukt = $get->kategori;
        $this->nominal_ukt = 'Rp. ' . rupiah($get->nominal);
        $this->dispatch('open-modal', modal: 'ModalUKT');
    }

    public function save()
    {
        $this->validate([
            'kategori_ukt' => 'required',
            'nominal_ukt' => 'required',
        ]);

        ProdiBiayastudi::where('id', $this->id)->update([
            'jenis_biaya' => 'ukt',
            'nominal' => rupiah($this->nominal_ukt, false),
            'kategori' => $this->kategori_ukt
        ]);

        $this->mount($this->prodi_id);

        $this->dispatch('alert', type: 'success', message: 'Biaya UKT Berhasil Disimpan.');
        $this->dispatch('close-modal', modal: 'ModalUKT');
    }

    public function _reset()
    {
        $this->kategori_ukt = "";
        $this->nominal_ukt = "";

        $this->resetErrorBag();
        $this->dispatch('close-modal', modal: 'ModalUKT');
    }
}
