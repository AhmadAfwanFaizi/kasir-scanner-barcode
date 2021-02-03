<?php

namespace App\Models;

use CodeIgniter\Model;

class Stok_m extends Model
{

    protected $colOrderAndSearch = array("kode_produk", "kode_produk", "nama_produk", "satuan", "stok_produk");
    protected $order             = array("kode_produk" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->builder       = $this->db->table("produk");
        $this->waktuSekarang = date("Y-m-d H:i:s");

        $this->dataTable = $this->db->table("produk P");
        $this->join      = $this->dataTable->join("kategori K", "K.id = P.id_kategori");
        $this->join      = $this->dataTable->join("satuan S", "S.id = P.id_kategori");
        $this->where     = $this->dataTable->where("P.dihapus", NULL);
    }

    private function _getDataTablesQuery($post = null)
    {
        $i = 0;
        foreach ($this->colOrderAndSearch as $item) {
            if (isset($post["search"]["value"])) {
                if ($i === 0) {
                    $this->dataTable->groupStart();
                    $this->dataTable->like($item, $post["search"]["value"]);
                } else {
                    $this->dataTable->orLike($item, $post["search"]["value"]);
                }
                if (count($this->colOrderAndSearch) - 1 == $i)
                    $this->dataTable->groupEnd();
            }
            $i++;
        }
        if (isset($post["order"])) {
            $this->dataTable->orderBy($this->colOrderAndSearch[$post["order"]["0"]["column"]], $post["order"]["0"]["dir"]);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dataTable->orderBy(key($order), $order[key($order)]);
        }
        return $this;
    }
    function getDataTables($post)
    {
        $this->_getDataTablesQuery($post);
        if ($post["length"] != -1)
            $this->dataTable->limit($post["length"], $post["start"]);
        if ($this->join) $this->join;
        if ($this->where) $this->where;
        $query = $this->dataTable->get();
        return $query->getResult();
    }
    function countFiltered()
    {
        $this->_getDataTablesQuery();
        if ($this->join) $this->join;
        if ($this->where) $this->where;
        return $this->dataTable->countAllResults();
    }
    public function countAll()
    {
        if ($this->join) $this->join;
        if ($this->where) $this->where;
        return $this->countAllResults();
    }
}
