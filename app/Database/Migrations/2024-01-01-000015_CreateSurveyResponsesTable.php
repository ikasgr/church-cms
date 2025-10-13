<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSurveyResponsesTable extends Migration
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
            'question_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'respondent_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'respondent_email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'answer' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('survey_id');
        $this->forge->addKey('question_id');
        $this->forge->addForeignKey('survey_id', 'survey', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('question_id', 'survey_questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('survey_responses');
    }

    public function down()
    {
        $this->forge->dropTable('survey_responses');
    }
}
