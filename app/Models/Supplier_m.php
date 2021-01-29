<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libray;

class Supplier_m extends Model
{
    protected $column_order  = array('kode_supplier', 'nama_supplier', 'kontak_supplier', 'alamat_supplier');
    protected $column_search = array('kode_supplier', 'nama_supplier', 'kontak_supplier', 'alamat_supplier');
    protected $order         = array('nama_supplier' => 'asc');

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table("supplier");
    }

    private function _get_datatables_query($post = null)
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if (isset($post['search']['value'])) {
                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, $post['search']['value']);
                } else {
                    $this->builder->orLike($item, $post['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }
        if (isset($post['order'])) {
            $this->builder->orderBy($this->column_order[$post['order']['0']['column']], $post['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables($post)
    {
        $this->_get_datatables_query($post);
        if ($post['length'] != -1)
            $this->builder->limit($post['length'], $post['start']);
        $this->builder->where("dihapus", NULL);
        $query = $this->builder->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->builder->where("dihapus", NULL);
        return $this->builder->countAllResults();
    }
    public function count_all()
    {
        $this->builder->where("dihapus", NULL);
        return $this->countAllResults();
    }

    public function tambah($post)
    {
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
