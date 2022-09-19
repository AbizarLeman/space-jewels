<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home.php');
        #return view('welcome_message');
    }
}
