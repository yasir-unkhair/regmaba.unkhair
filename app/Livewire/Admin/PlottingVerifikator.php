<?php

namespace App\Livewire\Admin;

use App\Models\Fakultas;
use App\Models\Pesertaukt;
use App\Models\PesertauktVerifikasiBerkas;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PlottingVerifikator extends Component
{
    use WithPagination;

    public $judul = "Plotting Verifikator";
    public $user;
    public $jalur;
    public $jml_peserta = 0;

    public $prodi_id = '';

    public $pencarian = '';
    public $perPage = 20;

    public function mount($params)
    {
        $params = decode_arr($params);
        // dd($params, $params['jalur']);
        $this->user = User::where('id', $params['verifikator_id'])->first();
        $this->jml_peserta = $this->user->verifikasipeserta()->where('app_peserta.jalur', $params['jalur'])->count();
        $this->jalur = $params['jalur'];
    }

    public function render()
    {
        $fakultas = Fakultas::with('prodi')->where('nama_fakultas', '!=', 'PASCASARJANA')->orderBy('nama_fakultas', 'ASC')->get();

        if ($this->prodi_id) {
            $this->resetPage();
        }

        $setup = get_setup();

        $listdata = Pesertaukt::with(['prodi', 'verifikasiberkas'])
            ->setup($setup->id)
            ->status([3, 4, 5])
            ->prodi($this->prodi_id)
            ->pencarian($this->pencarian)
            ->orderBy('jalur', 'ASC')->orderBy('prodi_id', 'ASC')->orderBy('nama_peserta', 'ASC')
            ->paginate($this->perPage);

        $data = [
            'fakultas' => $fakultas,
            'pesertaukt' => $listdata,
            'verifikator_id' => $this->user->id,
            'tahun' => $setup->tahun,
        ];
        return view('livewire.admin.plotting-verifikator', $data)
            ->extends('layouts.backend')
            ->section('content');
    }

    #[On('act-pilih')]
    public function pilih($params, $act)
    {
        // $this->jml_peserta = 1;
        $params = decode_arr($params);
        // dd($params, $act);

        $peserta_id = $params['peserta_id'];
        $verifikator_id = $params['verifikator_id'];

        $verifikasi = PesertauktVerifikasiBerkas::where('peserta_id', $peserta_id)->first();

        if (!$verifikasi) {
            PesertauktVerifikasiBerkas::create([
                'peserta_id' => $peserta_id,
                'verifikator_id' => $verifikator_id
            ]);
        } else {
            if ($act == 'add') {
                $verifikasi->where('peserta_id', $peserta_id)->update(['verifikator_id' => $verifikator_id]);
            }
            if ($act == 'remove') {
                $verifikasi->where('peserta_id', $peserta_id)->update(['verifikator_id' => NULL]);
            }
        }

        $this->jml_peserta = $this->user->verifikasipeserta()->where('app_peserta.jalur', $this->jalur)->count();
    }
}
