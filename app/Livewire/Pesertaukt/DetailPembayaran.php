<?php

namespace App\Livewire\Pesertaukt;

use App\Jobs\GenerateNPM;
use App\Libraries\BankBni;
use App\Libraries\BankBtn;
use App\Models\PesertauktPembayaran;
use App\Models\ProsesData;
use Illuminate\Support\Carbon;
use Livewire\Component;

class DetailPembayaran extends Component
{
    public $params;

    public $pembayaran_id;
    public $trx_id;
    public $va;
    public $amount = 0;
    public $expired;
    public $lunas;
    public $bank;
    public $detail_pembayaran;

    public function select()
    {
        $get = PesertauktPembayaran::where('id', $this->params['pembayaran_id'])->first();
        $this->pembayaran_id = $get->id;
        $this->trx_id = $get->trx_id ?? NULL;
        $this->va = $get->va ?? NULL;
        $this->amount = $get->amount ?? 0;
        $this->expired = $get->expired ?? NULL;
        $this->lunas = $get->lunas;

        if ($get->bank == 'BTN') {
            $this->bank = 'BTN - Virtual Account';
        } elseif ($get->bank == 'BNI') {
            $this->bank = 'BNI - Host To Host';
        }
        $this->detail_pembayaran = $get->detail_pembayaran;
    }

    public function mount($params)
    {
        $this->params = decode_arr($params);
        $this->select();
    }

    public function render()
    {
        return view('livewire.pesertaukt.detail-pembayaran');
    }

    public function generateva($params, $act = 'create')
    {
        $pembayaran = PesertauktPembayaran::where('id', data_params($params, 'pembayaran_id'))->first();

        $setup = get_setup();
        $batas_pembayaran_ukt = NULL;
        // jalur snbp
        if (session('jalur') == 'SNBP') {
            $batas_pembayaran_ukt = $setup->pembayaran_snbp;
        }
        // jalur snbt
        elseif (session('jalur') == 'SNBT') {
            $batas_pembayaran_ukt = $setup->pembayaran_snbt;
        }
        // jalur mandiri
        elseif (session('jalur') == 'MANDIRI') {
            $batas_pembayaran_ukt = $setup->pembayaran_mandiri;
        }

        $err = 0;
        // jika batas pembayaran telah berakhir
        if (!status_jadwal($batas_pembayaran_ukt)) {
            $err++;
        }

        if (!$err) {
            $expired_va = Carbon::now()->diffInDays(pecah_jadwal($batas_pembayaran_ukt, 1));
            $expired_va = ($expired_va < 2) ? 1 : 3;

            $res = NULL;
            switch ($pembayaran->bank) {
                case 'bni':
                case 'BNI':
                    $bank = new BankBni();
                    if ($act == 'create') {
                        $res = $bank->createva($pembayaran, $expired_va);
                    } else {
                        $res = $bank->updateva($pembayaran, $expired_va);
                    }
                    break;

                case 'btn':
                case 'BTN':
                    $bank = new BankBtn();
                    if ($act == 'create') {
                        $res = $bank->createva($pembayaran, $expired_va);
                    } else {
                        $res = $bank->updateva($pembayaran, $expired_va);
                    }
                    break;

                default:
                    abort(404);
                    break;
            }

            if ($res['rsp']) {
                $pembayaran->update($res['data']);
                $this->select();
                $this->dispatch('alert', type: 'success', message: $res['msg']);
            } else {
                $this->dispatch('alert', type: 'error', message: $res['msg']);
            }
        } else {
            // $this->dispatch('alert', type: 'error', message: '');
            abort(404);
        }
    }

    public function cekstatus($params)
    {
        if (!$params || !data_params($params, 'pembayaran_id')) {
            abort(404);
        }

        $err = 0;
        $pembayaran = PesertauktPembayaran::with('peserta')->where('id', data_params($params, 'pembayaran_id'))->first();
        if (!$pembayaran->trx_id) {
            $err++;
            $this->dispatch('alert', type: 'error', message: 'Pembayaran belum terkonfirmasi.');
        }

        if (!$err) {

            # cek va di ecoll
            $rsp = json_decode(get_data('https://ecoll.unkhair.ac.id/cekva.php?trx_id=' . $pembayaran->trx_id), TRUE);
            // dd($pembayaran->peserta->id, trim($pembayaran->jenis_pembayaran));
            if ($rsp['response'] == true) {
                if (!$pembayaran->lunas) {
                    // dd($pembayaran->peserta->id, trim($pembayaran->peserta?->npm));
                    $pembayaran->update([
                        'lunas' => 1,
                        'tgl_pelunasan' => now()
                    ]);

                    // update notif lunas ukt di verifikasi_peserta
                    $pembayaran->peserta->verifikasiberkas->update([
                        'bayar_ukt' => 1
                    ]);

                    if ($pembayaran->jenis_pembayaran == 'ukt' && empty(trim($pembayaran->peserta?->npm))) {

                        //set notif
                        ProsesData::updateOrCreate([
                            'source' => $pembayaran->peserta->id,
                            'queue' => 'generate-npm'
                        ], [
                            'source' => $pembayaran->peserta->id,
                            'queue' => 'generate-npm'
                        ]);

                        // generate npm
                        dispatch(new GenerateNPM($pembayaran->peserta->id));
                    }
                }
                $this->select();
                $this->dispatch('alert', type: 'success', message: 'Pembayaran telah terkonfirmasi.');
            } else {
                $this->dispatch('alert', type: 'error', message: 'Pembayaran belum terkonfirmasi.');
            }
        }
    }
}
