<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_m extends Model
{

    protected $table             = "kategori";
    protected $colOrderAndSearch = array("id", "kategori");
    protected $order             = array("kategori" => "asc");

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

    public function getDataKategori($post = null)
    {
        if ($post) return $this->builder->getWhere(["id" => $post["idKategori"]])->getRow();
        else return $this->builder->get()->getResult();
    }

    public function tambah($post)
    {
        $data = [
            "kategori" => $post["kategoriProduk"],
        ];
        $this->builder->insert($data);
    }

    public function ubah($post)
    {
        $data = [
            "kategori" => $post["kategoriProduk"],
        ];
        $this->builder->where(["id" => $post["idKategori"]])->update($data);
    }

    public function hapus($post)
    {
        $this->builder->where(["id" => $post["idKategori"]])->update(["dihapus" => $this->waktuSekarang]);
    }

    // ======================================================
}
