<?php

namespace App\Controllers;

use App\Models\Produk_m;

class Produk extends BaseController
{

    public function __construct()
    {
        $this->produk_m = new Produk_m();
    }

    public function data()
    {
        $data = [
            'page' => 'data produk',
        ];
        return view('produk/data', $data);
    }

    public function getDataTableProduk()
    {
        if ($this->request->getMethod(true) == "POST") {
            $post = $this->request->getPost();
            $list = $this->produk_m->getDataTables($post);
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($list as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->kode_produk;
                $row[] = $list->nama_produk;
                $row[] = $list->jenis_produk;
                $row[] = $list->satuan_produk;
                $row[] = "Rp. " . $list->harga_produk;
                $row[] = '<button type="button" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></button> ' .
                    '<button type="button" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>';

                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost("draw"),
                "recordsTotal"    => $this->produk_m->countAll(),
                "recordsFiltered" => $this->produk_m->countFiltered(),
                "data"            => $data,
            ];
            return json_encode($output);
        }
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
