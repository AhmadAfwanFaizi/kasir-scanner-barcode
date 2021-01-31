<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk_m extends Model
{

    protected $column_order  = array("kode_produk", "nama_produk", "kategori", "satuan", "harga_produk");
    protected $column_search = array("kode_produk", "nama_produk", "kategori", "satuan", "harga_produk");
    protected $order         = array("nama_produk" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table("produk P");
        // ->select("P.kode_produk, P.nama_produk, K.kategori, S.satuan, P.harga_produk");
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
        $this->builder->join("kategori K", "K.id = P.id_kategori");
        $this->builder->join("satuan S", "S.id = P.id_satuan");
        $this->builder->where("P.dihapus", NULL);
        $query = $this->builder->get();
        return $query->getResult();
    }
    function countFiltered()
    {
        $this->_getDataTablesQuery();
        $this->builder->join("kategori K", "K.id = P.id_kategori");
        $this->builder->join("satuan S", "S.id = P.id_satuan");
        $this->builder->where("P.dihapus", NULL);
        return $this->builder->countAllResults();
    }
    public function countAll()
    {
        $this->builder->join("kategori K", "K.id = P.id_kategori");
        $this->builder->join("satuan S", "S.id = P.id_satuan");
        $this->builder->where("P.dihapus", NULL);
        return $this->countAllResults();
    }

    public function getDataProduk($post)
    {
        if ($post) return $this->builder->getWhere(["kode_produk" => $post["kodeProduk"]])->getRow();
        else return $this->builder->get()->getResult();

        // return $this->builder->getWhere(["kode_produk" => $post["kodeProduk"]])->getRow();
    }

    public function tambah($post)
    {
        $data = [
            "id_user"       => 1,
            "kode_produk"   => $post["kodeProduk"],
            "id_kategori" => $post["kategoriProduk"],
            "id_satuan"   => $post["satuanProduk"],
            "nama_produk"   => $post["namaProduk"],
            "harga_produk"  => $post["hargaProduk"],
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
