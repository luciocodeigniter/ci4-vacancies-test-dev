<?php


namespace App\Libraries;


class Token
{

    public function __construct($token = null)
    {
        if (is_null($token)) {

            $this->token = bin2hex(random_bytes(16));
        } else {

            $this->token = $token;
        }
    }

    public function getValue()
    {
        return $this->token;
    }

    public function getHash()
    {
        return hash_hmac('sha256', $this->token, env('HASH_SECRET_KEY_ACCOUNT_ACTIVATION'));
    }
}
