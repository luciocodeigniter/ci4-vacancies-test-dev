<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Libraries\Token;

class RememberedLoginModel extends Model
{
    protected $table = 'remembered_login';
    protected $returnType = 'object';
    protected $allowedFields = ['token_hash', 'user_id', 'expire_at'];


    public function rememberUserLogin(int $user_id)
    {
        $token = new Token;

        $tokenHash = $token->getHash();

        $expiry = time() + 864000; //Token expira em 10 dias

        $data = [
            'token_hash' => $tokenHash,
            'user_id' => $user_id,
            'expire_at' => date('Y-m-d H:i:s', $expiry)
        ];

        $this->insert($data);

        // Data to set the cookie
        return [
            $token->getValue(),
            $expiry
        ];
    }

    public function findByToken(string $token)
    {
        $token = new Token($token);

        // Get the tokenHash from token
        $tokenHash = $token->getHash();

        // Try to get the row from tokenHash
        $remenberedLogin = $this->where('token_hash', $tokenHash)->first();

        // Did we find?
        if (is_null($remenberedLogin)) {

            return null;
        }

        // Is still valid?
        if ($remenberedLogin->expire_at < date('Y-m-d H:i:s')) {

            return null;
        }

        // Yes, is valid
        return $remenberedLogin;
    }


    public function deleteByToken($token)
    {
        $token = new Token($token);

        $token_hash = $token->getHash();

        $this->where('token_hash', $token_hash)->delete();
    }

    public function deleteExpired()
    {
        $this->where('expire_at <', date('Y-m-d H:i:s'))->delete();

        return $this->db->affectedRows();
    }
}
