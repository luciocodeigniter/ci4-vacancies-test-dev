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

    public function markAsVerified()
    {
        $this->activation_hash = null;
        $this->email_verified_at = date('Y-m-d H:i:s');
    }

    public function startPasswordReset()
    {
        $token = new Token();

        // Create the property 'token' that will be used to send to email user for revovery
        $this->token = $token->getValue();

        // Generate the reset_hash from token that will be stored
        $this->reset_hash = $token->getHash();

        // Generate the expiration date for token that will be send to user
        $this->reset_expires_at = date('Y-m-d H:i:s', time() + 7200); // 2 hours from now
    }


    public function completePasswordReset()
    {
        $this->reset_hash = null;
        $this->reset_expires_at = null;
    }

    public function active()
    {
        return $this->is_active ? 'Acesso Liberado' : 'Acesso Bloqueado';
    }

    public function verified()
    {
        return $this->email_verified_at ? 'Conta verificada' : 'Conta não verificada';
    }
}
