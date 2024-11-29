<?php

namespace App\Jobs;

use App\Libraries\AppSupport;
use App\Models\Pembayaran;
use App\Models\PesertauktPembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProsesLunasPembayaran implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $trx_id = $this->data['trx_id'];
        $billing = $this->data['billing'];

        $pembayaran = PesertauktPembayaran::where('trx_id', $trx_id)->where('billing', $billing)->first();
        if ($pembayaran && !$pembayaran->lunas) {

            // update set lunas pembayaran
            $pembayaran->update([
                'lunas' => 1,
                'tgl_pelunasan' => now()
            ]);

            // genarate NPM bagi jenis pembayaran ukt
            if (strtolower($pembayaran->jenis_pembayaran) == 'ukt' && is_null($pembayaran->peserta->npm)) {

                $peserta = $pembayaran->peserta()->first();

                $tahun = $peserta->setup->tahun ?? date('Y');
                $kode_prefix = $peserta->prodi->prefix_npm;

                $support = new AppSupport();
                $npm = $support->GenerateNpm($peserta->setup_id, $tahun, $kode_prefix);

                // update npm
                $pembayaran->peserta->update([
                    'npm' => $npm,
                    'tgl_generate' => now()
                ]);

                // update notif lunas ukt di verifikasi_peserta
                $peserta->verifikasiberkas->update([
                    'bayar_ukt' => 1
                ]);
            }
        }
    }
}
