<?php

namespace App\Controllers;

class Game extends BaseController
{
    public function index()
    {
        return view('gamepage.php', ['name' => $this->request->getVar('name')]);
    }
}
