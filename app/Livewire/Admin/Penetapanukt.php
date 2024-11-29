<?php

namespace App\Livewire\Admin;

use App\Jobs\SendMail;
use App\Models\Pesertaukt;
use App\Models\ProdiBiayastudi;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;
use Livewire\Component;

class Penetapanukt extends Component
{
    public $get;
    public $verifikator;
    public $tgl_verifikasi;
    public $catatan;
    public $rekomendasi;

    public $listdata_ukt = [];
    public $listdata_ipi = [];

    public $kategori_ukt;
    public $kategori_ipi;

    public function render()
    {
        return view('livewire.admin.penetapanukt');
    }

    public function save()
    {
        // Clear previous errors
        $this->resetErrorBag();

        $rules = ['kategori_ukt' => 'required'];

        $jalur = strtolower($this->get->jalur);
        if ($jalur == 'mandiri') {
            $rules += ['kategori_ipi' => 'required'];
        }

        $this->validate($rules);

        $kategori_ukt = $this->kategori_ukt;
        $nominal_ukt = 0;

        $kategori_ipi = $this->kategori_ipi;
        $nominal_ipi = 0;
        if (!in_array($this->kategori_ukt, ['wawancara', 'kip-k'])) {
            $ukt = ProdiBiayastudi::where('id', $this->kategori_ukt)->first();
            $kategori_ukt = 'k' . $ukt->kategori;
            $nominal_ukt = (int) abs($ukt->nominal);
            if (!$nominal_ukt) {
                $this->addError("kategori_ukt", "Nomimal UKT tidak valid!");
            }
        }

        if ($jalur == 'mandiri') {
            $ipi = ProdiBiayastudi::where('id', $this->kategori_ipi)->first();
            $kategori_ipi = 'k' . $ipi->kategori;
            $nominal_ipi = (int) abs($ipi->nominal);
            if (!$nominal_ipi) {
                $this->addError("kategori_ipi", "Nomimal IPI tidak valid!");
            }
        }

        if (!$this->getErrorBag()->all()) {
            $data = [
                'vonis_ukt' => $kategori_ukt,
                'nominal_ukt' => $nominal_ukt,
                'vonis_ipi' => $kategori_ipi,
                'nominal_ipi' => $nominal_ipi,
                'tgl_vonis' => now(),
                'user_id_vonis' => auth()->user()->id
            ];

            // dd($this->get->email, $this->get);

            $this->get->update(['status' => 5]);
            $this->get->verifikasiberkas->update($data);

            // kirim notif email ke peserta bahwa admin telah melakukan vonis ukt
            SendMail::dispatch([
                'email' => $this->get->email,
                'get' => $this->get,
                'content' => 'penetapanukt'
            ]);

            $this->dispatch('alert', type: 'success', message: 'Penetapan UKT Berhasil Disimpan');
            $this->dispatch('load-datatable');
            $this->dispatch('close-modal');

            // alert()->success('Success', 'Penetapan UKT Berhasil Disimpan.');
            // return $this->redirect(route('admin.penetapanukt.index'));
        }
    }

    #[On('modal-penetapanukt')]
    public function modal_penetapanukt($params)
    {
        $params = decode_arr($params);
        $this->get = Pesertaukt::with('verifikasiberkas')->where('id', $params['peserta_id'])->first();

        $this->listdata_ukt = ProdiBiayastudi::byprodi($this->get->prodi_id)->jenisbiaya('ukt')->orderBy('kategori', 'ASC')->get();
        $this->listdata_ipi = ProdiBiayastudi::byprodi($this->get->prodi_id)->jenisbiaya('ipi')->orderBy('kategori', 'ASC')->get();

        $this->verifikator = $this->get->verifikasiberkas?->verifikator?->name;
        $this->tgl_verifikasi = $this->get->verifikasiberkas?->tgl_verifikasi;
        $this->catatan = $this->get->verifikasiberkas?->catatan;
        $this->rekomendasi = $this->get->verifikasiberkas?->rekomendasi;

        $this->kategori_ukt = $this->get->verifikasiberkas?->vonis_ukt;

        if (strtolower($this->get->jalur) == 'mandiri') {
            $this->kategori_ipi = $this->get->verifikasiberkas?->vonis_ipi;
        }
        $this->dispatch('open-modal');
    }

    public function _reset()
    {
        $this->resetErrorBag();

        $this->get = NULL;
        // $this->listdata_ukt = NULL;
        // $this->listdata_ipi = NULL;
        $this->verifikator = NULL;
        $this->tgl_verifikasi = NULL;
        $this->catatan = NULL;
        $this->rekomendasi = NULL;
        $this->kategori_ukt = NULL;
        $this->kategori_ipi = NULL;

        $this->dispatch('close-modal');
    }
}
