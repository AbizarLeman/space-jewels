<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHighscore extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 100,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'player_name' => [
                'type' => 'VARCHAR',
                'constraint' => 128
            ],
            'score' => [
                'type' => 'INT',
                'constraint' => 100
            ],
            'time' => [
                'type' => 'TIMESTAMP'
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('highscore');
    }

    public function down()
    {
        $this->forge->dropTable('highscore');
    }
}
