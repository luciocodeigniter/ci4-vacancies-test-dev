<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'is_active' => 'boolean'
    ];

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }
}
