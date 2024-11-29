<?php

namespace App\Livewire\Master;

use App\Models\Fakultas as ModelsFakultas;
use Livewire\Component;
use Livewire\WithPagination;

class Fakultas extends Component
{
    use WithPagination;

    public $judul = "Data Fakultas";
    public $pencarian = '';
    public $perPage = 10;


    public function render()
    {
        if ($this->pencarian) {
            $this->resetPage();
        }
        $listdata = ModelsFakultas::pencarian($this->pencarian)->orderBy('nama_fakultas', 'ASC')->paginate($this->perPage);
        return view('livewire.master.fakultas', ['listdata' => $listdata])
            ->extends('layouts.backend')
            ->section('content');
    }

    public function importSimak()
    {
        $token = get_token();
        if ($token && $token['status'] == 200) {
            $response = json_decode(get_data(str_curl(pengaturan('url-simak') . '/apiv2/index.php/fakultas', ['token' => $token['data']['token']])), TRUE);
            if ($response && $response['status'] == 200) {
                $success = 0;
                foreach ($response['data'] as $row) {
                    $proses = ModelsFakultas::updateOrCreate(
                        [
                            'id' => $row['id_fakultas']
                        ],
                        [
                            'id' => $row['id_fakultas'],
                            'nama_fakultas' => ucwords(strtolower($row['nama_fakultas'])),
                            'status' => $row['status'],
                        ]
                    );
                    if ($proses) {
                        $success++;
                    }
                }
                alert()->success('Success', 'Sebanyak ' . $success . ' fakultas berhasil diimport dari SIMAK!');
            } else {
                alert()->error('Error', 'Terjadi kesalahan saat ambil data!');
            }
        } else {
            alert()->error('Error', 'Terjadi kesalahan saat pembuatan token!');
        }
        return redirect(route('admin.fakultas'));
    }
}
