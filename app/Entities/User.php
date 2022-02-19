<?php

namespace App\Entities;

use App\Libraries\Token;
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

    public function startActivation()
    {
        $token = new Token();

        // Create the property 'token' to user object to send to email account activation
        $this->token = $token->getValue();

        // Generate the hash to store in database
        $this->activation_hash = $token->getHash();
    }
}
