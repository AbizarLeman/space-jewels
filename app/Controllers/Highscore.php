<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Highscore extends BaseController
{
    public function index()
    {
        $model = new \App\Models\HighscoreModel;
        $data = $model->orderBy('score', 'desc')->findAll();
    
        return view('highscore.php' , ['highscores' => $data]);
    }
}
