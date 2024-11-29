<?php

namespace App\Http\Controllers\Pesertaukt;

use App\Http\Controllers\Controller;
use App\Models\Pesertaukt;
use Illuminate\Http\Request;

class CetakFormuliruktController extends Controller
{
    //
    public function index()
    {
        $data = [
            'judul' => 'Formulir UKT',
        ];

        return view('backend.pesertaukt.cetakformulir', $data);
    }
}
