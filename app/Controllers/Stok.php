<?php

namespace App\Controllers;

use App\Models\Stok_m;

use App\Libraries\SSD;

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

    public function getDataStok($param = null)
    {
        if ($param) $post = $param;
        else $post = $this->request->getPost();

        $data = $this->stok_m->getDataStok($post);
        if ($param) return $data;
        else return json_encode($data);
    }

    public function getDataTableStok()
    {
        if ($this->request->getMethod(true) == "POST") {
            $post = $this->request->getPost();
            // $ssd = new SSD($post);

            // $ssd->searchAndOrder("ST.id", "ST.kode_produk", "nama_produk", "satuan", "stok_produk", "nama_supplier", "ST.dibuat");
            // $ssd->table("stok ST");
            // $ssd->select("ST.id as id_stok, ST.kode_produk, P.nama_produk, S.satuan, ST.jumlah, SUP.nama_supplier, ST.dibuat");
            // $ssd->join("produk P", "P.kode_produk = ST.kode_produk");

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
                $row[] = $list->jumlah;
                $row[] = $list->nama_supplier;
                $row[] = $list->dibuat;
                $row[] = '<button type="button" class="btn btn-sm btn-warning" onclick="formUbahDataStok(' . "'" . $list->id_stok . "'" . ')"><i class="fas fa-edit"></i></button> ';

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

    public function tambah()
    {
        $post = $this->request->getPost();
        $this->stok_m->tambah($post);
        if ($this->db->affectedRows()) {
            return "200";
        }
    }

    public function ubah()
    {
        $post = $this->request->getPost();
        $this->stok_m->ubah($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200",
                "data" => $this->getDataStok($post),
            ];
            return json_encode($data);
        }
    }

    public function hapus()
    {
        $post = $this->request->getPost();
        $c = $this->stok_m->hapus($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200"
            ];

            return json_encode($data);
        }
    }

    //--------------------------------------------------------------------
}
