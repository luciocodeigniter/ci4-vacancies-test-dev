<?php

namespace App\Models;

use App\Entities\User;
use App\Libraries\Token;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $returnType       = User::class;
    protected $allowedFields    = [
        'name', 'email', 'activation_hash', 'password', 'reset_hash', 'reset_expire_at'
    ];


    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[240]|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required|matches[password]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'O campo Nome é obrigatório.',
        ],
        'email' => [
            'required' => 'O campo E-mail é obrigatório.',
            'is_unique' => 'Desculpe. Esse e-mail já existe. Por favor escolha outro.',
        ],
        'password' => [
            'required' => 'O campo Senha é obrigatório.',
        ],
        'password_confirmation' => [
            'required' => 'O campo Confirmação da senha é obrigatório.',
            'matches' => 'As senhas precisam combinar.',
        ],
    ];


    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     *
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);
        }

        return $data;
    }

    public function getByCriteria(array $criteria)
    {
        return $this->where($criteria)->first();
    }

    public function isAdmin(int $userId): bool
    {
        $query = $this->db->table('users_admin')->where('user_id', $userId);

        return $query->get()->getRow() !== null;
    }

    public function activateByToken(string $token): bool
    {
        $token = new Token($token);

        // Generate de hash from token
        $tokenHash = $token->getHash();

        // Try to get the user who has the $tokenHash
        $user = $this->where('activation_hash', $tokenHash)->first();

        // Did we find?
        if (is_null($user)) {

            return false;
        }

        // Activate the user
        $user->activate();

        return $this->protect(false)->save($user);
    }
}
