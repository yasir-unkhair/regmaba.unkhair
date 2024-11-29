<?php

namespace App\Livewire\Sistem;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ImportUserSimak extends Component
{
    public $judul = "Import Pengguna SIMAK";
    public $id;
    public $name;
    public $email;
    public $username;
    public $password;
    public $is_active = 1;
    public $role_pengguna = [];

    public $level;

    public $currentStep = 1;

    public function render()
    {
        $roles = Role::whereNotIn('name', ['peserta', 'developper'])->select('name')->orderBy('id', 'ASC')->get();
        return view('livewire.sistem.import-user-simak', ['roles' => $roles])
            ->extends('layouts.backend')
            ->section('content');
    }

    public function check()
    {
        $this->validate([
            'username' => 'required|unique:users,username',
            'level' => 'required'
        ]);

        $sukses = false;
        $token = get_token();
        if ($token && $token['status'] == 200) {
            if ($this->level == 'admin') {
                $response = json_decode(get_data(str_curl(pengaturan('url-simak') . '/apiv2/index.php/admin', ['token' => $token['data']['token'], 'username' => $this->username])), TRUE);
                //dd($response);
                if ($response && $response['status'] == 200) {
                    $get = $response['data']['admin'];
                    $this->username = $get['username'];
                    $this->name = $get['nama_lengkap'];
                    $this->email = $get['email'];
                    $this->is_active = ($get['blokir'] == 'N') ? 1 : 0;
                    $this->password = $get['password'];
                    $sukses = true;
                } else {
                    flash('danger', $response['status'] . ' - ' . $response['message']);
                }
            }

            if ($this->level == 'dosen') {
                $response = json_decode(get_data(str_curl(pengaturan('url-simak') . '/apiv2/index.php/dosen', ['token' => $token['data']['token'], 'nidn' => $this->username])), TRUE);
                // dd($response, $response['data']['dosen']);
                if ($response && $response['status'] == 200) {
                    $get = $response['data']['dosen'];
                    $this->username = $get['nidn'];
                    $this->name = trim(trim($get['gelar_depan']) . ' ' . trim($get['nama_dosen']) . ', ' . trim($get['gelar_belakang']));
                    $this->email = $get['email'];
                    $this->is_active = (strtolower($get['nama_status_aktif']) == 'aktif') ? 1 : 0;
                    $this->password = $get['password'];
                    $sukses = true;
                } else {
                    flash('danger', $response['status'] . ' - ' . $response['message']);
                }
            }
        } else {
            flash('danger', 'Terjadi kesalahan saat pembuatan token!');
        }

        // dd($this);
        if ($sukses) {
            $this->currentStep = 2;
        }
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function save()
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role_pengguna' => ['required', 'array', 'min:1']
        ]);
        // dd($this);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'is_active' => $this->is_active,
            'user_simak' => 1 // 1 pengguna yg bersumber dr simak 
        ]);

        if ($user->roles()->count()) {
            foreach ($user->roles()->get() as $row) {
                $user->removeRole($row->name);
            }
        }

        foreach ($this->role_pengguna as $role) {
            $user->assignRole($role);
        }

        $this->clear();

        alert()->success('Success', 'Pengguna SIMAK berhasil ditambahkan.');
        return $this->redirect(route('admin.pengguna'));
    }

    public function clear()
    {
        $this->currentStep = 1;
        $this->username = '';
        $this->name = '';
        $this->email = '';
        $this->role_pengguna = [];
    }
}
