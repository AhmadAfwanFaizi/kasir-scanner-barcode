<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk_m extends Model
{

    protected $column_order  = array("kode_produk", "nama_produk", "kategori", "satuan", "harga_produk", "stok_produk");
    protected $column_search = array("kode_produk", "nama_produk", "kategori", "satuan", "harga_produk", "stok_produk");
    protected $order         = array("nama_produk" => "asc");


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
        foreach ($this->column_search as $item) {
            if (isset($post["search"]["value"])) {
                if ($i === 0) {
                    $this->dataTable->groupStart();
                    $this->dataTable->like($item, $post["search"]["value"]);
                } else {
                    $this->dataTable->orLike($item, $post["search"]["value"]);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dataTable->groupEnd();
            }
            $i++;
        }
        if (isset($post["order"])) {
            $this->dataTable->orderBy($this->column_order[$post["order"]["0"]["column"]], $post["order"]["0"]["dir"]);
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
        $this->join;
        $this->dataTable->where("P.dihapus", NULL);
        $query = $this->dataTable->get();
        return $query->getResult();
    }
    function countFiltered()
    {
        $this->_getDataTablesQuery();
        $this->join;
        $this->dataTable->where("P.dihapus", NULL);
        return $this->dataTable->countAllResults();
    }
    public function countAll()
    {
        $this->join;
        $this->dataTable->where("P.dihapus", NULL);
        return $this->countAllResults();
    }

    public function getDataProduk($post)
    {
        if ($post) return $this->builder->getWhere(["kode_produk" => $post["kodeProduk"]])->getRow();
        else return $this->builder->get()->getResult();
    }

    public function tambah($post)
    {
        $data = [
            "id_user"      => 1,
            "kode_produk"  => $post["kodeProduk"],
            "id_kategori"  => $post["kategoriProduk"],
            "id_satuan"    => $post["satuanProduk"],
            "nama_produk"  => $post["namaProduk"],
            "harga_produk" => $post["hargaProduk"],
            "stok_produk"  => 0
        ];
        $this->builder->insert($data);
    }

    public function ubah($post)
    {
        $data = [
            "id_kategori"  => $post["kategoriProduk"],
            "id_satuan"    => $post["satuanProduk"],
            "nama_produk"  => $post["namaProduk"],
            "harga_produk" => $post["hargaProduk"],
        ];
        $this->builder->where(["kode_produk"  => $post["kodeProduk"]])->update($data);
    }

    public function hapus($post)
    {
        $this->builder->where(["kode_produk"  => $post["kodeProduk"]])->update(["dihapus" => $this->waktuSekarang]);
    }

    // ======================================================
}
