<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSurveyQuestionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'survey_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'question' => [
                'type' => 'TEXT',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['text', 'multiple_choice', 'checkbox', 'rating'],
                'default'    => 'text',
            ],
            'options' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_required' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'order_position' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('survey_id');
        $this->forge->addForeignKey('survey_id', 'survey', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('survey_questions');
    }

    public function down()
    {
        $this->forge->dropTable('survey_questions');
    }
}
