<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        $data['content'] = view('home_view');

        return view('template', $data);
    }
}
