<?php

namespace App\Controllers;

class Supplier extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'data supplier',
        ];
        return view('supplier/data', $data);
    }

    //--------------------------------------------------------------------

}
