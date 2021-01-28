<?php

namespace App\Controllers;

use App\Models\Supplier_m;

class Supplier extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->supplier_m = new Supplier_m();
    }

    public function index()
    {
        $data = [
            'page' => 'data supplier',
            'data' => $this->supplier_m->get(),
        ];
        var_dump($data);
        die;
        return view('supplier/data', $data);
    }

    public function tambah()
    {
        $post = $this->request->getPost();
        $this->supplier_m->tambah($post);
        if ($this->db->affectedRows()) {
            return "200";
        }
    }



    //--------------------------------------------------------------------

}
