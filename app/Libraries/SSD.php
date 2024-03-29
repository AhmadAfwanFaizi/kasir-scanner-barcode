<?php

namespace App\Libraries;

class SSD
{
    protected $db;
    protected $builder;
    protected $select;
    protected $columnOrder;
    protected $columnSearch;
    protected $order;
    protected $selectOrder;
    protected $param;

    protected $where;
    protected $join;
    protected $post;

    public function __construct($post = null)
    {
        $this->db = db_connect();
        $this->post;
        // $this->builder;
        // $this->select;
        // $this->columnOrder;
        // $this->columnSearch;
        // $this->order;
        // $this->selectOrder;
        // $this->param;

        // $this->where;
        // $this->join;
        // $this->post;

    }

    public function table($table = null)
    {
        $this->builder = $this->db->table($table);
        return $this;
    }

    public function select($select = null)
    {
        $this->builder = $this->builder->select($select);
        return $this;
    }

    public function columnOrder($columnOrder = null)
    {
        $this->columnOrder = $columnOrder;
        return $this;
    }

    public function columnSearch($columnSearch = null)
    {
        $this->columnSearch = $columnSearch;
        return $this;
    }

    public function searchAndOrder($param = null)
    {

        if (strpos($param, ",")) {
            $data              = explode(",", $param);
            $this->selectOrder = $data[0];
            $this->select      = $data;
        } else {
            $data[]              = $param;
            $this->selectOrder = $data;
            $this->select      = $data;
        }

        $this->columnOrder($data);
        $this->columnSearch($data);
    }

    public function order($order = null)
    {
        if ($order != null) $this->order = [$order => "ASC"];
        else $this->order = [$this->selectOrder => "ASC"];
        return $this;
    }

    public function join($param1 = null, $param2 = null)
    {
        $data = [];
        array_push($data, $param1, $param2);
        $this->join = $data;
        return $this;
    }

    public function where($where = null)
    {
        $this->where = $where;
        return $this;
    }

    private function _getDataTablesQuery($post = null)
    {
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
    function getDataTables($post = null)
    {
        $this->_getDataTablesQuery($this->post);
        if ($this->post["length"] != -1)
            $this->builder->limit($this->post["length"], $this->post["start"]);

        if ($this->join) $this->builder->join($this->join[0], $this->join[1]);
        if ($this->where) $this->builder->where($this->where);
        $query = $this->builder->get();
        return $query->getResult();
    }
    function countFiltered()
    {
        $this->_getDataTablesQuery();

        if ($this->join) $this->builder->join($this->join[0], $this->join[1]);
        if ($this->where) $this->builder->where($this->where);
        return $this->builder->countAllResults();
    }
    function countAll()
    {

        if ($this->join) $this->builder->join($this->join[0], $this->join[1]);
        if ($this->where) $this->builder->where($this->where);
        return $this->builder->countAllResults();
    }
}
