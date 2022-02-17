<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Libraries\Token;

class RememberedLoginModel extends Model
{
    protected $table = 'remembered_login';
    protected $returnType = 'object';
    protected $allowedFields = ['token_hash', 'user_id', 'expire_at'];

    public function rememberUserLogin($user_id)
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


        /**
         * Retornamos esse array para que possamos setar o cookie
         */
        return [
            $token->getValue(),
            $expiry
        ];
    }

    public function findByToken(string $token)
    {
        $token = new Token($token);

        $tokenHash = $token->getHash();

        $remembered_login = $this->where('token_hash', $tokenHash)->first();

        /**
         * Verificamos se foi encontrado o registro de acordo com $token_hash
         */
        if ($remembered_login) {


            /**
             * Se $remembered_login->expire_at for maior que a hora e data atuais, então retornamos o objeto $remembered_login
             */
            if ($remembered_login->expire_at > date('Y-m-d H:i:s')) {

                return $remembered_login;
            }
        }
    }

    /**
     * @descrição: Esse método será chamado no método logout() da classe Autenticacao e removerá da tabela 'remembered_login'
     *             o registro de acordo com o $token.
     * 
     *             Dessa forma o usuário não será logado automaticamente, pois o token_hash não existe mais na tabela 'remembered_login'
     * 
     * @param Token $token
     */
    public function deleteByToken($token)
    {

        $token = new Token($token);

        $token_hash = $token->getHash();

        $this->where('token_hash', $token_hash)->delete();
    }

    /**
     * @descrição retorna número inteiro denotando a quantidade de registros excluídos da tabela 'remembered_login' que estejam expirados
     * 
     * @return int 
     */
    public function deleteExpired()
    {
        $this->where('expire_at <', date('Y-m-d H:i:s'))->delete();

        return $this->db->affectedRows();
    }
}
