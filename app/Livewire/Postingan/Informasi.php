<?php

namespace App\Livewire\Postingan;

use App\Models\Postingan;
use Livewire\Component;
use Livewire\WithPagination;

class Informasi extends Component
{
    use WithPagination;

    public string $judul = "Daftar Informasi";
    public string $pencarian = "";

    public int $perPage = 10;

    public function render()
    {
        if ($this->pencarian) {
            $this->resetPage();
        }

        $listdata = Postingan::pencarian($this->pencarian)->orderBy('created_at', 'DESC')->paginate($this->perPage);
        return view('livewire.postingan.informasi', ['listdata' => $listdata])
            ->extends('layouts.backend')
            ->section('content');
    }
}
