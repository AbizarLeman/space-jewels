<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Highscore extends BaseController
{
    public function index()
    {
        return view('highscore.php');
    }
}
