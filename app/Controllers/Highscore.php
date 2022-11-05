<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Highscore extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new \App\Models\HighscoreModel;
        $data = $model->orderBy('score', 'desc')->findAll();
    
        return view('highscore.php' , ['highscores' => $data]);
    }

    public function create()
    {
        $score = $this->request->getVar();

        $model = new \App\Models\HighscoreModel;
        $model->insert($score);

        return $this->response->setStatusCode(200);
    }
}
