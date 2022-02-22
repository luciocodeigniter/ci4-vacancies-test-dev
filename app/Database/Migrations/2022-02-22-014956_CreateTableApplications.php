<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableApplications extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'vacancy_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);


        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('vacancy_id', 'vacancies', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('applications');
    }

    public function down()
    {
        $this->forge->dropTable('applications');
    }
}
