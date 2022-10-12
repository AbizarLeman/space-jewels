<?php

namespace App\Controllers;

class Game extends BaseController
{
    public function index($name)
    {
        return view('gamepage.php', ['name' => $name]);
    }
}
