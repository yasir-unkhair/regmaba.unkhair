<?php

namespace App\Livewire\Sistem;

use App\Models\Referensi as ModelsReferensi;
use Livewire\Component;
use Livewire\WithPagination;

class Referensi extends Component
{
    use WithPagination;
    public $judul = "Daftar Referensi";

    public $id;
    public $parent_id;
    public $referensi;
    public $mode = 'new';

    public $pencarian = '';
    public $perPage = 5;

    public $listReferensi = [];

    public function render()
    {
        $listdata = ModelsReferensi::with('subReferensi')->where('parent_id', NULL)->pencarian($this->pencarian)->orderBy('created_at', 'DESC')->paginate($this->perPage);
        return view('livewire.sistem.referensi-index', ['listdata' => $listdata])
            ->extends('layouts.backend')
            ->section('content');
    }

    public function mount(): void
    {
        $this->listReferensi = ModelsReferensi::select(['id', 'referensi'])->where('parent_id', NULL)->orderBy('created_at', 'DESC')->get();
    }

    public function hydrate()
    {
        $this->listReferensi = ModelsReferensi::select(['id', 'referensi'])->where('parent_id', NULL)->orderBy('created_at', 'DESC')->get();
    }

    public function open_modal($modal_id)
    {
        $this->dispatch('open-modal', modal_id: $modal_id);
    }


    public function saveReferensi()
    {
        $this->validate([
            'referensi' => 'required|string'
        ]);

        $ref = new ModelsReferensi();

        if ($this->mode == 'new') {
            $ref->create([
                'referensi' => $this->referensi
            ]);
        } elseif ($this->mode == 'edit') {
            $ref->where('id', $this->id)->update([
                'referensi' => $this->referensi
            ]);
        }
        $this->_reset('ModalUpdateReferensi');
    }

    public function saveSubReferensi()
    {
        $this->validate([
            'parent_id' => 'required|string',
            'referensi' => 'required|string',
        ]);

        $ref = new ModelsReferensi();

        if ($this->mode == 'new') {
            $ref->create([
                'parent_id' => $this->parent_id,
                'referensi' => $this->referensi
            ]);
        } elseif ($this->mode == 'edit') {
            $ref->where('id', $this->id)->update([
                'parent_id' => $this->parent_id,
                'referensi' => $this->referensi
            ]);
        }
        $this->_reset('ModalUpdateSubReferensi');
    }

    public function edit($id, $modal_id)
    {
        $get = ModelsReferensi::where('id', $id)->first();
        $this->id = $get->id;
        $this->parent_id = $get->parent_id;
        $this->referensi = $get->referensi;
        $this->mode = 'edit';

        $this->dispatch('open-modal', modal_id: $modal_id);
    }

    public function _reset($modal_id = null)
    {
        $this->resetErrorBag();

        $this->id = '';
        $this->parent_id = '';
        $this->referensi = '';
        $this->mode = 'new';

        $this->dispatch('close-modal', modal_id: $modal_id);
    }
}
