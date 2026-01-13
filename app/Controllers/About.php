<?php

namespace App\Controllers;

// Controller Halaman About
class About extends BaseController
{
    public function index()
    {
        return view('about_view');
    }
}
