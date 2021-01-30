<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk_m extends Model
{

    protected $column_order  = array("kode_produk", "nama_produk", "kategori_produk", "satuan_produk", "harga_produk");
    protected $column_search = array("kode_produk", "nama_produk", "kategori_produk", "satuan_produk", "harga_produk");
    protected $order         = array("nama_produk" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table("produk");
    }

    private function _getDataTablesQuery($post = null)
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if (isset($post["search"]["value"])) {
                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, $post["search"]["value"]);
                } else {
                    $this->builder->orLike($item, $post["search"]["value"]);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }
        if (isset($post["order"])) {
            $this->builder->orderBy($this->column_order[$post["order"]["0"]["column"]], $post["order"]["0"]["dir"]);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }
    function getDataTables($post)
    {
        $this->_getDataTablesQuery($post);
        if ($post["length"] != -1)
            $this->builder->limit($post["length"], $post["start"]);
        $this->builder->where("dihapus", NULL);
        $query = $this->builder->get();
        return $query->getResult();
    }
    function countFiltered()
    {
        $this->_getDataTablesQuery();
        $this->builder->where("dihapus", NULL);
        return $this->builder->countAllResults();
    }
    public function countAll()
    {
        $this->builder->where("dihapus", NULL);
        return $this->countAllResults();
    }

    public function getDataProduk($post)
    {
        return $this->builder->getWhere(["kode_produk" => $post["kodeProduk"]])->getRow();
    }

    // ======================================================
}
