<?php

namespace App\Controllers;

use App\Models\Stok_m;

class Stok extends BaseController
{
    public function __construct()
    {
        $this->stok_m = new Stok_m();
    }

    public function index()
    {
        $data = [
            'page' => 'data stok',
        ];

        return view('stok/data', $data);
    }

    public function getDataTableStok()
    {
        if ($this->request->getMethod(true) == "POST") {
            $post = $this->request->getPost();
            $list = $this->stok_m->getDataTables($post);
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($list as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->kode_produk;
                $row[] = $list->nama_produk;
                $row[] = $list->satuan;
                $row[] = $list->stok_produk;
                $row[] = '<button type="button" class="btn btn-sm btn-success" onclick="formTambahDataStok(' . "'" . $list->kode_produk . "'" . ')"><i class="fas fa-plus"></i></button> ' .
                    '<button type="button" class="btn btn-sm btn-danger" onclick="formKurangDataStok(' . "'" . $list->kode_produk . "'" . ')"><i class="fas fa-minus"></i></button>';

                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost("draw"),
                "recordsTotal"    => $this->stok_m->countAll(),
                "recordsFiltered" => $this->stok_m->countFiltered(),
                "data"            => $data,
            ];
            return json_encode($output);
        }
    }

    //--------------------------------------------------------------------
}
