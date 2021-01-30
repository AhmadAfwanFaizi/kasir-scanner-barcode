<?php

namespace App\Libraries;

class coba
{

    protected $column_order  = array('kode_supplier', 'nama_supplier', 'kontak_supplier', 'alamat_supplier');
    protected $column_search = array('kode_supplier', 'nama_supplier', 'kontak_supplier', 'alamat_supplier');
    protected $order         = array('nama_supplier' => 'asc');
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table("supplier");
    }

    public function tableName($table = null)
    {
        return $table;
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
        return $this->builder->countAllResults();
    }

    public function output($post)
    {
        $lists = $this->get_datatables($post);
        $data = [];
        $no = $post["start"];
        foreach ($lists as $list) {
            $no++;
            $row      = [];
            $row[]    = $no;
            $row[]    = $list->kode_supplier;
            $row[]    = $list->nama_supplier;
            $row[]    = $list->kontak_supplier;
            $row[]    = $list->alamat_supplier;
            $row[]    = '<button type="button" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></button> ' .
                '<button type="button" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>';
            $data[]   = $row;
        }
        $output = [
            "draw"            => $post['draw'],
            "recordsTotal"    => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data"            => $data
        ];
        echo json_encode($output);
    }
}
