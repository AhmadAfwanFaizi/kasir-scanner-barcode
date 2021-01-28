<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier_m extends Model
{
    protected $table = "supplier";

    public function get()
    {
        return $this->db->table("supplier")->get();
    }

    public function tambah($post)
    {

        // var_dump($post['namaSupplier']);
        // die;
        $data = [
            "id_user" => 1,
            "kode_supplier" => uniqid(),
            "nama_supplier" => $post['namaSupplier'],
            "kontak_supplier" => $post['kontakSupplier'],
            "alamat_supplier" => $post['alamatSupplier'],
        ];
        $this->db->table("supplier")->insert($data);
    }
}
