<?php

namespace App\Controllers;

class Produk extends BaseController
{
    public function data()
    {
        $data = [
            'page' => 'data produk',
        ];
        return view('produk/data', $data);
    }

    public function kategori()
    {
        $data = [
            'page' => 'kategori produk',
        ];
        return view('produk/kategori', $data);
    }

    public function satuan()
    {
        $data = [
            'page' => 'satuan produk',
        ];
        return view('produk/satuan', $data);
    }

    //--------------------------------------------------------------------

}
