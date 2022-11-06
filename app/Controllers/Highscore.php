<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Highscore extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        try {
            $model = new \App\Models\HighscoreModel;
            $data = $model->orderBy('score', 'desc')->findAll();
        
            return view('highscore.php' , ['highscores' => $data]);
        } catch (\Throwable $th) {
            return view('highscore.php' , ['highscores' => []]);
        }
    }

    public function create()
    {
        try {
            $score = $this->request->getVar();

            $model = new \App\Models\HighscoreModel;
            $model->insert($score);
        } catch (\Throwable $th) {
        }

        return $this->response->setStatusCode(200);
    }
}
