<?php

namespace App\Controllers;

use App\Models\Supplier_m;
use App\Libraries\coba;

class Supplier extends BaseController
{
    public function __construct()
    {
        $this->db = db_connect();
        $this->supplier_m = new Supplier_m();
        $this->coba = new coba();
    }

    public function index()
    {
        $data = [
            'page' => 'data supplier',
            'data' => $this->supplier_m->get()->getResult(),
        ];

        return view('supplier/data', $data);
    }

    public function getDataSupplier($param = null)
    {
        if ($param) $post = $param;
        else $post = $this->request->getPost();

        $data = $this->supplier_m->getDataSupplier($post);
        if ($param) return $data;
        else return json_encode($data);
    }

    public function dataTableSupplier()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $post = $this->request->getPost();
            $lists = $this->supplier_m->get_datatables($post);
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row      = [];
                $row[]    = $no;
                $row[]    = $list->kode_supplier;
                $row[]    = $list->nama_supplier;
                $row[]    = $list->kontak_supplier;
                $row[]    = $list->alamat_supplier;
                $row[]    = '<button type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="formUbahDataSupplier(' . "'" . $list->kode_supplier . "'" . ')"><i class="far fa-edit"></i></button> ' .
                    '<button type="button" class="btn btn-sm btn-danger" onclick="formHapusDataSupplier(' . "'" . $list->kode_supplier . "'" . ')"><i class="far fa-trash-alt"></i></button>';
                $data[]   = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->supplier_m->count_all(),
                "recordsFiltered" => $this->supplier_m->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }

    public function tambah()
    {
        $post = $this->request->getPost();
        $this->supplier_m->tambah($post);
        if ($this->db->affectedRows()) {
            return "200";
        }
    }

    public function ubah()
    {
        $post = $this->request->getPost();
        $this->supplier_m->ubah($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200",
                "data" => $this->getDataSupplier($post),
            ];
            return json_encode($data);
        }
    }

    public function hapus()
    {
        $post = $this->request->getPost();
        $this->supplier_m->hapus($post);
        if ($this->db->affectedRows()) {
            $data = [
                "status" => "200"
            ];

            return json_encode($data);
        }
    }



    //--------------------------------------------------------------------

}
