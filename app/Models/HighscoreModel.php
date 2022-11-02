<?php

namespace App\Models;

class HighscoreModel extends \CodeIgniter\Model
{
    protected $table = 'highscore';
    protected $allowedFields = ['player_name', 'score', 'datetime'];
    protected $returnType = 'App\Entities\Highscore';
}

?>