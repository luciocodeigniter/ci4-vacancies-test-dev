<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableVacancies extends Migration
{
    public function up()
    {
        $fields = [
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'title'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'unique'         => true,
            ],
            'is_paused'      => [
                'type'           => 'BOOLEAN',
                'default'        => false
            ],
            'description' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'type'      => [
                'type'           => 'ENUM',
                'constraint'     => ['fr', 'pf', 'pj'],
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('vacancies');
    }

    public function down()
    {
        $this->forge->dropTable('vacancies');
    }
}
