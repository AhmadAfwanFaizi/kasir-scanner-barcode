<?php

namespace App\Controllers;

use App\Libraries\coba;

use App\Models\Produk_m;
use App\Models\Kategori_m;
use App\Models\Satuan_m;

class Produk extends BaseController
{

    public function __construct()
    {
        $this->produk_m   = new Produk_m();
        $this->kategori_m = new Kategori_m();
        $this->satuan_m   = new Satuan_m();

        $this->coba  = new coba();
    }
    // PRODUK ==================================================

    public function data()
    {
        $data = [
            'page' => 'data produk',
        ];
        return view('produk/data', $data);
    }

    public function getDataProduk($param = null)
    {
        if ($param) $post = $param;
        else $post = $this->request->getPost();

        $data = $this->produk_m->getDataProduk($post);
        if ($param) return $data;
        else return json_encode($data);
    }

    public function selectInputProduk()
    {
        $data = [
            "status"   => "200",
            "kategori" => json_decode($this->getDataKategori()),
            "satuan"   => json_decode($this->getDataSatuan()),
        ];
        return json_encode($data);
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
                $row[] = $list->kategori;
                $row[] = $list->satuan;
                $row[] = "Rp. " . $list->harga_produk;
                $row[] = $list->stok_produk;
                $row[] = '<button type="button" class="btn btn-sm btn-warning" onclick="formUbahDataProduk(' . "'" . $list->kode_produk . "'" . ')"><i class="far fa-edit"></i></button> ' .
                    '<button type="button" class="btn btn-sm btn-danger" onclick="formHapusDataProduk(' . "'" . $list->kode_produk . "'" . ')"><i class="far fa-trash-alt"></i></button>';

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

    public function tambahDataProduk()
    {
        $post = $this->request->getPost();
        $this->produk_m->tambah($post);
        if ($this->db->affectedRows()) {
            return "200";
        }
    }

    public function ubahDataProduk()
    {
        $post = $this->request->getPost();
        $this->produk_m->ubah($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200",
                "data" => $this->getDataProduk($post),
            ];
            return json_encode($data);
        }
    }

    public function hapusDataProduk()
    {
        $post = $this->request->getPost();
        $this->produk_m->hapus($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200"
            ];

            return json_encode($data);
        }
    }

    // KATEGORI ==================================================

    public function kategori()
    {
        $data = [
            'page' => 'kategori produk',
        ];
        return view('produk/kategori', $data);
    }

    public function getDataKategori($param = null)
    {
        if ($param) $post = $param;
        else $post = $this->request->getPost();

        $data = $this->kategori_m->getDataKategori($post);
        if ($param) return $data;
        else return json_encode($data);
    }

    public function getDataTableKategori()
    {
        $this->coba->table("kategori");
        $this->coba->columnOrder(["kategori"]);
        $this->coba->columnSearch(["kategori"]);
        $this->coba->order(["kategori" => "asc"]);

        $this->coba->where(["dihapus" => NULL]);

        // if ($this->request->getMethod(true) == "POST") {
        $post = $this->request->getPost();
        $list = $this->coba->getDataTables($post);
        $data = [];
        $no = $this->request->getPost("start");
        foreach ($list as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->kategori;
            $row[] = '<button type="button" class="btn btn-sm btn-warning" onclick="formUbahDataKategori(' . "'" . $list->id . "'" . ')"><i class="far fa-edit"></i></button> ' .
                '<button type="button" class="btn btn-sm btn-danger" onclick="formHapusDataKategori(' . "'" . $list->id . "'" . ')"><i class="far fa-trash-alt"></i></button>';

            $data[] = $row;
        }
        $output = [
            "draw"            => $this->request->getPost("draw"),
            "recordsTotal"    => $this->coba->countAll(),
            "recordsFiltered" => $this->coba->countFiltered(),
            "data"            => $data,
        ];
        return json_encode($output);
        // }
    }

    public function tambahDataKategori()
    {
        $post = $this->request->getPost();
        $this->kategori_m->tambah($post);
        if ($this->db->affectedRows()) {
            return "200";
        }
    }

    public function ubahDataKategori()
    {
        $post = $this->request->getPost();
        $this->kategori_m->ubah($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200",
                "data" => $this->getDataKategori($post),
            ];
            return json_encode($data);
        }
    }

    public function hapusDataKategori()
    {
        $post = $this->request->getPost();
        $this->kategori_m->hapus($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200"
            ];

            return json_encode($data);
        }
    }

    // SATUAN ==================================================

    public function satuan()
    {
        $data = [
            'page' => 'satuan produk',
        ];
        return view('produk/satuan', $data);
    }

    public function getDataSatuan($param = null)
    {
        if ($param) $post = $param;
        else $post = $this->request->getPost();

        $data = $this->satuan_m->getDataSatuan($post);
        if ($param) return $data;
        else return json_encode($data);
    }

    public function getDataTableSatuan()
    {
        if ($this->request->getMethod(true) == "POST") {
            $post = $this->request->getPost();
            $list = $this->satuan_m->getDataTables($post);
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($list as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->satuan;
                $row[] = '<button type="button" class="btn btn-sm btn-warning" onclick="formUbahDataSatuan(' . "'" . $list->id . "'" . ')"><i class="far fa-edit"></i></button> ' .
                    '<button type="button" class="btn btn-sm btn-danger" onclick="formHapusDataSatuan(' . "'" . $list->id . "'" . ')"><i class="far fa-trash-alt"></i></button>';

                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost("draw"),
                "recordsTotal"    => $this->satuan_m->countAll(),
                "recordsFiltered" => $this->satuan_m->countFiltered(),
                "data"            => $data,
            ];
            return json_encode($output);
        }
    }

    public function tambahDataSatuan()
    {
        $post = $this->request->getPost();
        $this->satuan_m->tambah($post);
        if ($this->db->affectedRows()) {
            return "200";
        }
    }

    public function ubahDataSatuan()
    {
        $post = $this->request->getPost();
        $this->satuan_m->ubah($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200",
                "data" => $this->getDataSatuan($post),
            ];
            return json_encode($data);
        }
    }

    public function hapusDataSatuan()
    {
        $post = $this->request->getPost();
        $this->satuan_m->hapus($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200"
            ];

            return json_encode($data);
        }
    }

    //--------------------------------------------------------------------

}
