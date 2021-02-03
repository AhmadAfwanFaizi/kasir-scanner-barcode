<?php

namespace App\Models;

use CodeIgniter\Model;

class Stok_m extends Model
{

    protected $colOrderAndSearch = array("ST.id", "ST.kode_produk", "nama_produk", "satuan", "stok_produk", "nama_supplier");
    protected $order             = array("st.kode_produk" => "asc");

    public function __construct()
    {
        parent::__construct();
        $this->builder       = $this->db->table("stok");
        $this->waktuSekarang = date("Y-m-d H:i:s");

        $this->dataTable = $this->db->table("stok ST")
            ->select("ST.id as id_stok, ST.kode_produk, P.nama_produk, S.satuan, ST.jumlah, SUP.nama_supplier, ST.dibuat");
        $this->join      = $this->dataTable->join("produk P", "P.kode_produk = ST.kode_produk");
        $this->join      = $this->dataTable->join("satuan S", "S.id = P.id_satuan");
        $this->join      = $this->dataTable->join("supplier SUP", "SUP.kode_supplier = ST.kode_supplier");
        // $this->where     = $this->dataTable->where("P.dihapus", NULL);
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

    public function getDataStok($post = null)
    {
        if ($post) return $this->builder->getWhere(["id" => $post["id"]])->getRow();
        else return $this->builder->get()->getResult();
    }

    public function tambah($post)
    {
        $data = [
            "id_user"       => 1,
            "kode_produk"   => $post["kodeProduk"],
            "kode_supplier" => $post["kodeSupplier"],
            "jumlah"        => $post["jumlah"],
            "log_stok"      => "MASUK",
            "catatan"       => $post["catatan"]
        ];
        $this->builder->insert($data);

        $this->db->query("UPDATE produk SET 
        stok_produk = stok_produk + '$post[jumlah]' 
        WHERE kode_produk = '$post[kodeProduk]'");
    }

    public function ubah($post)
    {
        $data = [
            "nama_supplier" => $post["namaSupplier"],
            "kontak_supplier" => $post["kontakSupplier"],
            "alamat_supplier" => $post["alamatSupplier"],
        ];
        $this->builder->where(["kode_supplier" => $post["kodeSupplier"]])->update($data);
    }

    public function hapus($post)
    {
        $this->builder->where(["kode_supplier" => $post["kodeSupplier"]])->update(["dihapus" => $this->waktuSekarang]);
    }
}
