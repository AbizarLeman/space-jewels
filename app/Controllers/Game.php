<?php

namespace App\Controllers;

class Game extends BaseController
{
    public function index($name)
    {
        $model = new \App\Models\HighscoreModel;
        $data = $model->orderBy('score', 'desc')->first();

        return view('gamepage.php', ['name' => $name, 'highscore' => $data->score]);
    }
}
