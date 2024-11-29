<?php

namespace App\Livewire\Master;

use App\Models\Fakultas;
use App\Models\Prodi as ModelsProdi;
use Livewire\Attributes\On;
use Livewire\Component;

class Prodi extends Component
{
    public $id = '';
    public $kode_prodi = '';
    public $nama_prodi = '';
    public $fakultas_id = '';
    public $fakultas = [];

    public function mount(): void
    {
        $this->fakultas = Fakultas::orderBy('nama_fakultas', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.master.prodi');
    }


    #[On('edit-prodi')]
    public function edit($prodi_id)
    {
        $prodi = ModelsProdi::where('id', $prodi_id)->first();
        $this->id = $prodi->id;
        $this->kode_prodi = $prodi->kode_prodi;
        $this->nama_prodi = $prodi->nama_prodi;
        $this->fakultas_id = $prodi->fakultas_id;

        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate([
            'nama_prodi' => 'required|string',
            'fakultas_id' => 'required'
        ]);

        ModelsProdi::where('id', $this->id)
            ->update([
                'nama_prodi' => $this->nama_prodi,
                'fakultas_id' => $this->fakultas_id,
            ]);

        return redirect(route('admin.prodi.index'));
    }

    public function _reset()
    {
        $this->id = "";
        $this->kode_prodi = "";
        $this->nama_prodi = "";
        $this->fakultas_id = "";

        $this->resetErrorBag();
        $this->dispatch('close-modal');
    }
}
