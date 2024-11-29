<?php

namespace App\Libraries;

use Illuminate\Support\Carbon;

class BankBtn
{
    private $message;
    private $apikey = '*#un1v3RS1T45Kh41Run*#*';

    public function createva($pembayaran, $expired_va)
    {
        $params = [];
        if ($pembayaran->jenis_pembayaran == 'pemkes') {
            $params = [
                'apikey' => $this->apikey,
                'demo' => false,
                'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va 1 hari
                'kode_payment' => '006',
                'jenis_payment' => 'PEMKES Mahasiswa Baru',
                'prefix_trx' => 'PKM',
                'nama' => $pembayaran->peserta->nama_peserta,
                'nominal' => $pembayaran->nominal,
                'deskripsi' => 'Pemeriksaan Kesehatan Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun,
            ];
        } elseif ($pembayaran->jenis_pembayaran == 'ipi') {
            $params = [
                'demo' => false,
                'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va 1 hari
                'apikey' => $this->apikey,
                'kode_payment' => '003',
                'jenis_payment' => 'IPI Mahasiswa Baru',
                'prefix_trx' => 'IPI',
                'nama' => $pembayaran->peserta->nama_peserta,
                'nominal' => $pembayaran->nominal,
                'deskripsi' => 'IPI Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun,
            ];
        } elseif ($pembayaran->jenis_pembayaran == 'ukt') {
            $params = [
                'demo' => false,
                'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va
                'apikey' => $this->apikey,
                'kode_payment' => '007',
                'jenis_payment' => 'UKT Mahasiswa Baru',
                'prefix_trx' => 'UKT',
                'nama' => $pembayaran->peserta->nama_peserta,
                'nominal' => $pembayaran->nominal,
                'deskripsi' => 'UKT Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun,
            ];
        }

        $response = json_decode(post_data('http://ecoll.unkhair.ac.id/btn/createva.php', $params), TRUE);
        if (!$response['response']) {
            $this->message = $response['pesan'];
            return [
                'rsp' => false,
                'msg' => $this->message
            ];
        }

        $this->message = 'Berhasil Membuat Virtual Account BANK BTN';
        return [
            'rsp' => true,
            'msg' => $this->message,
            'data' => [
                'trx_id' => $response['data']['trx_id'],
                'billing' => $response['data']['va'],
                'expired' => $response['data']['expired_va'],
            ]
        ];
    }

    public function updateva($pembayaran, $expired_va)
    {
        $params = [];
        if ($pembayaran->jenis_pembayaran == 'pemkes') {
            $params = [
                'apikey' => $this->apikey,
                'demo' => false,
                'trx' => $pembayaran->trx_id,
                'va' => $pembayaran->billing,
                'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va 1 hari
                'kode_payment' => '006',
                'jenis_payment' => 'PEMKES Mahasiswa Baru',
                'nama' => $pembayaran->peserta->nama_peserta,
                'nominal' => $pembayaran->nominal,
                'deskripsi' => 'Pemeriksaan Kesehatan Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun,
            ];
        } elseif ($pembayaran->jenis_pembayaran == 'ipi') {
            $params = [
                'apikey' => $this->apikey,
                'demo' => false,
                'trx' => $pembayaran->trx_id,
                'va' => $pembayaran->billing,
                'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va 1 hari
                'kode_payment' => '003',
                'jenis_payment' => 'IPI Mahasiswa Baru',
                'nama' => $pembayaran->peserta->nama_peserta,
                'nominal' => $pembayaran->nominal,
                'deskripsi' => 'IPI Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun,
            ];
        } elseif ($pembayaran->jenis_pembayaran == 'ukt') {
            $expired_va = Carbon::now()->diffInDays($this->batas_pembayaran_ukt);
            $params = [
                'apikey' => $this->apikey,
                'demo' => false,
                'trx' => $pembayaran->trx_id,
                'va' => $pembayaran->billing,
                'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va
                'kode_payment' => '007',
                'jenis_payment' => 'UKT Mahasiswa Baru',
                'nama' => $pembayaran->peserta->nama_peserta,
                'nominal' => $pembayaran->nominal,
                'deskripsi' => 'UKT Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun,
            ];
        }

        $response = json_decode(post_data('http://ecoll.unkhair.ac.id/btn/updateva.php', $params), TRUE);
        if (!$response['response']) {
            $this->message = $response['pesan'];
            return [
                'rsp' => false,
                'msg' => $this->message
            ];
        }

        $this->message = 'Berhasil Update Virtual Account BANK BTN';
        return [
            'rsp' => true,
            'msg' => $this->message,
            'data' => [
                'trx_id' => $response['data']['trx_id'],
                'billing' => $response['data']['va'],
                'expired' => $response['data']['expired_va'],
            ]
        ];
    }
    public function getMessage()
    {
        return $this->message;
    }
}
