<?php

namespace App\Models;

use CodeIgniter\Model;

class Satuan_m extends Model
{
    protected $table             = "satuan";
    protected $colOrderAndSearch = array("id", "satuan");
    protected $order             = array("satuan" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->builder       = $this->db->table($this->table);
        $this->waktuSekarang = date("Y-m-d H:i:s");

        $this->dataTable = $this->db->table($this->table);
        $this->where     = $this->dataTable->where("dihapus", NULL);
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

    public function getDatasatuan($post = null)
    {
        if ($post) return $this->builder->getWhere(["id" => $post["idSatuan"]])->getRow();
        else return $this->builder->get()->getResult();
    }

    public function tambah($post)
    {
        $data = [
            "satuan" => $post["satuanProduk"],
        ];
        $this->builder->insert($data);
    }

    public function ubah($post)
    {
        $data = [
            "satuan" => $post["satuanProduk"],
        ];
        $this->builder->where(["id" => $post["idSatuan"]])->update($data);
    }

    public function hapus($post)
    {
        $this->builder->where(["id" => $post["idSatuan"]])->update(["dihapus" => $this->waktuSekarang]);
    }

    // ======================================================
}
