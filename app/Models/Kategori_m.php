<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_m extends Model
{

    protected $column_order  = array("kategori");
    protected $column_search = array("kategori");
    protected $order         = array("kategori" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table("kategori");
        $this->waktuSekarang = date("Y-m-d H:i:s");
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

    public function getDataKategori($post)
    {
        return $this->builder->getWhere(["id" => $post["idKategori"]])->getRow();
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
