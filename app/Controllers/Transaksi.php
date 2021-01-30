<?php

namespace App\Controllers;

class Transaksi extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'transaksi',
        ];
        return view('transaksi/transaksi', $data);
    }

    //--------------------------------------------------------------------

}
