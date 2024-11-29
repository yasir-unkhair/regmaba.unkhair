<?php

namespace App\Libraries;

use Illuminate\Support\Carbon;

class BankBni
{
    private $message;
    private $apikey = '*#un1v3RS1T45Kh41Run*#*';

    public function createva($pembayaran, $expired_va = 1)
    {
        // create va
        $params = [
            'apikey' => $this->apikey,
            'type' => 'createbilling',
            'trx_id' => 'UKTMABA' . $pembayaran->peserta->setup->tahun . rand(10, 99) . time(),
            'trx_amount' => $pembayaran->nominal,
            'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va 1 hari
            'customer_name' => $pembayaran->peserta->nama_peserta,
            'customer_email' => $pembayaran->peserta->email,
            'description' => 'UKT Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun
        ];
        $response = json_decode(post_data('http://ecoll.unkhair.ac.id/bni/createva.php', $params), TRUE);
        if (!$response['response']) {
            $this->message = 'Terjadi Kesalah Saat Membuat Virtual Account BANK BNI!';
            return [
                'rsp' => false,
                'msg' => $this->message
            ];
        }

        // inquiry va
        $params = [
            'apikey' => $this->apikey,
            'trx_id' => $response['data']['trx_id'],
        ];

        $response = json_decode(post_data('http://ecoll.unkhair.ac.id/bni/inquiry.php', $params), TRUE);
        if (!$response['response']) {
            $this->message = 'Terjadi Kesalah Saat Inquiry Virtual Account BANK BNI';
            return [
                'rsp' => false,
                'msg' => $this->message
            ];
        }

        $this->message = 'Berhasil Membuat Virtual Account BANK BNI';
        return [
            'rsp' => true,
            'msg' => $this->message,
            'data' => [
                'trx_id' => $response['data']['trx_id'],
                'billing' => $response['data']['virtual_account'],
                'expired' => $response['data']['datetime_expired'],
            ]
        ];
    }

    public function updateva($pembayaran, $expired_va = 1)
    {
        // create va
        $params = [
            'apikey' => $this->apikey,
            'type' => 'updatebilling',
            'trx_id' => $pembayaran->trx_id,
            'virtual_account' => $pembayaran->billing,
            'trx_amount' => $pembayaran->nominal,
            'expired_va' => ($expired_va) ? $expired_va : 1, // expired_va
            'customer_name' => $pembayaran->peserta->nama_peserta,
            'customer_email' => $pembayaran->peserta->email,
            'description' => 'UKT Mahasiswa Baru ' . $pembayaran->peserta->setup->tahun
        ];
        $response = json_decode(post_data('http://ecoll.unkhair.ac.id/bni/createva.php', $params), TRUE);
        if (!$response['response']) {
            $this->message = 'Terjadi Kesalah Saat Update Virtual Account BANK BNI!';
            return [
                'rsp' => false,
                'msg' => $this->message
            ];
        }

        // inquiry va
        $params = [
            'apikey' => $this->apikey,
            'trx_id' => $response['data']['trx_id'],
        ];

        $response = json_decode(post_data('http://ecoll.unkhair.ac.id/bni/inquiry.php', $params), TRUE);
        if (!$response['response']) {
            $this->message = 'Terjadi Kesalah Saat Inquiry Virtual Account BANK BNI';
            return [
                'rsp' => false,
                'msg' => $this->message
            ];
        }

        $this->message = 'Berhasil Update Virtual Account BANK BNI';
        return [
            'rsp' => true,
            'msg' => $this->message,
            'data' => [
                'trx_id' => $response['data']['trx_id'],
                'billing' => $response['data']['virtual_account'],
                'expired' => $response['data']['datetime_expired'],
            ]
        ];
    }
    public function getMessage()
    {
        return $this->message;
    }
}
