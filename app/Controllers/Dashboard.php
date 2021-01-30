<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'page' => 'dashboard'
        ];
        return view('dashboard/dashboard', $data);
    }

    //--------------------------------------------------------------------

}
