<?php

namespace App\Livewire\Verifikator;

use App\Models\PesertauktVerifikasiBerkas;
use Livewire\Component;

class VerifikasiPesertaukt extends Component
{
    public $get;
    public $rekomendasi;
    public $catatan;

    public function mount($peserta_id)
    {
        $this->get = PesertauktVerifikasiBerkas::where('peserta_id', $peserta_id)->first();
        $this->rekomendasi = $this->get->rekomendasi;
        $this->catatan = $this->get->catatan;
    }
    public function render()
    {
        return view('livewire.verifikator.verifikasi-pesertaukt');
    }

    public function save()
    {
        $this->validate([
            'rekomendasi' => 'required',
            'catatan' => 'required'
        ]);

        $this->get->peserta->update([
            'status' => 4
        ]);

        $this->get->update([
            'rekomendasi' => $this->rekomendasi,
            'catatan' => $this->catatan,
            'verifies_id' => auth()->user()->id,
            'tgl_verifikasi' => now()
        ]);

        $this->mount($this->get->peserta_id);
        $this->dispatch('alert', type: 'success', message: 'Verifikasi peserta berhasil disimpan');
    }
}
