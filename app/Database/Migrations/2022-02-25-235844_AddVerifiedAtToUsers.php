<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerifiedAtToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'email_verified_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'email_verified_at');
    }
}
