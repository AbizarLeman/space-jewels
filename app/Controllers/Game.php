<?php

namespace App\Controllers;

class Game extends BaseController
{
    public function index($name)
    {
        try {
            $model = new \App\Models\HighscoreModel;
            $data = $model->orderBy('score', 'desc')->first();
    
            $seconds = $this->request->getVar("seconds");
    
            if ($seconds != "1000" && $seconds != "2000" && $seconds != "3000") {
                $seconds = "1000";
            }
    
            return view('gamepage.php', ['name' => $name, 'highscore' => $data->score]);
        } catch (\Throwable $th) {
            return view('gamepage.php', ['name' => $name, 'highscore' => 0]);
        }
    }
}
