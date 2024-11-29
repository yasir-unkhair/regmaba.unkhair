<?php

namespace App\Livewire\Sistem;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public $judul = "Role Pengguna";
    public $id;
    public $name;
    public $description;
    public $mode = "add";
    public function render()
    {
        $listrole = Role::select('id', 'name', 'description')->orderBy('id', 'ASC')->get();
        return view('livewire.sistem.roles-index', ['listdata' => $listrole])
            ->extends('layouts.backend')
            ->section('content');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($this->mode == 'add') {
            Role::create(
                [
                    'name' => $this->name,
                    'description' => $this->description
                ]
            );
            alert()->success('Success', 'Role berhasil ditambahkan.');
        }

        if ($this->mode == 'edit') {
            Role::where('id', $this->id)->update(
                [
                    'name' => $this->name,
                    'description' => $this->description
                ]
            );
            alert()->success('Success', 'Role berhasil ed edit.');
        }
        return $this->redirect(route('admin.roles'));
    }

    public function edit($id)
    {
        dd($id);
        $get = Role::where('id', $id)->first();
        $this->id = $get->id;
        $this->name = $get->name;
        $this->description = $get->description;
        $this->mode = "edit";
        $this->dispatch('open-modal');
    }

    public function _reset()
    {
        $this->resetErrorBag();
        $this->name = "";
        $this->description = "";
        $this->dispatch('close-modal');
    }
}
