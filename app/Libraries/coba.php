<?php

namespace App\Libraries;

class coba
{
    protected $db;
    protected $builder;
    protected $columnOrder;
    protected $columnSearch;
    protected $order;

    protected $where;

    public function __construct()
    {
        $this->db = db_connect();
        $this->waktuSekarang = date("Y-m-d H:i:s");
    }

    function table($table = null)
    {
        $this->builder = $this->db->table($table);
        return $this;
    }


    function columnOrder($columnOrder = null)
    {
        $this->columnOrder = $columnOrder;
        return $this;
    }

    function columnSearch($columnSearch = null)
    {
        $this->columnSearch = $columnSearch;
        return $this;
    }

    function order($order = null)
    {
        $this->order = $order;
        return $this;
    }

    function join($join = null)
    {
    }

    function where($where = null)
    {
        // $this->where = $this->builder->where($where);
        $this->where = $where;
        return $this;
    }

    private function _getDataTablesQuery($post = null)
    {
        // var_dump($this->columnOrder);
        // die;
        $i = 0;
        foreach ($this->columnSearch as $item) {
            if (isset($post["search"]["value"])) {
                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, $post["search"]["value"]);
                } else {
                    $this->builder->orLike($item, $post["search"]["value"]);
                }
                if (count($this->columnSearch) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }
        if (isset($post["order"])) {
            $this->builder->orderBy($this->columnOrder[$post["order"]["0"]["column"]], $post["order"]["0"]["dir"]);
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
        $this->builder->where($this->where);
        $query = $this->builder->get();
        return $query->getResult();
    }
    function countFiltered()
    {
        $this->_getDataTablesQuery();
        $this->builder->where($this->where);
        return $this->builder->countAllResults();
    }
    public function countAll()
    {
        $this->builder->where($this->where);
        return $this->builder->countAllResults();
    }

    public function output($post)
    {
        $lists = $this->getDataTables($post);
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
            "recordsTotal"    => $this->countAll(),
            "recordsFiltered" => $this->countFiltered(),
            "data"            => $data
        ];
        echo json_encode($output);
    }
}
