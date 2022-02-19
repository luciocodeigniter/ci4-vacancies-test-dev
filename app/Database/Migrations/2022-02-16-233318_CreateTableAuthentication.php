<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAuthentication extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'reset_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '64', // NÃO colocar o unique
                'null' => true,
                'default' => null,
            ],
            'reset_expire_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'activation_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
                'unique' => true
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'null' => false,
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

        $this->forge->addKey('id', true)->addUniqueKey('email');

        $this->forge->createTable('users');


        //----------Users admin---------------//


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

        ]);

        $this->forge->addKey('id', true)->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('users_admin');


        //----------Remembered Login---------------//

        $this->forge->addField([
            'token_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '64'
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'expire_at' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->forge->addPrimaryKey('token_hash')->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE')->addKey('expire_at'); //Criamos um index dessa coluna para podermos utilizar no controller

        $this->forge->createTable('remembered_login');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('users');
        $this->forge->dropTable('users_admin');
        $this->forge->dropTable('remembered_login');
    }
}
