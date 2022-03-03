<?php

namespace App\Models;

use App\Entities\User;
use App\Libraries\Token;
use CodeIgniter\Config\Factories;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $returnType       = User::class;
    protected $allowedFields    = [
        'name', 'email', 'activation_hash', 'password', 'reset_hash', 'reset_expire_at', 'email_verified_at'
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
        $user->markAsVerified();

        return $this->protect(false)->save($user);
    }

    public function getUserForPasswordReset(string $token)
    {
        $token = new Token($token);

        // Get hash from token
        $tokenHash = $token->getHash();

        // Try get the user from tokenHash
        $user = $this->where('reset_hash', $tokenHash)->first();

        // Did we find?
        if (is_null($user)) {

            return null;
        }

        // Good! User found. Now we validate de expiration of token
        // The expiration of token is greather than current datetime?
        if ($user->reset_expire_at > date('Y-m-d H:i:s')) {

            // Ohh no! Is expired...
            return null;
        }

        // Nice! Still valid!
        return $user;
    }

    public function getCandidates()
    {

        $tableFields = [
            'id',
            'name',
            'email',
            'is_active',
            'created_at',
            'updated_at',
            'email_verified_at',
        ];

        $usersId = $this->db->table('users_admin')->get()->getResult();
        $usersId = array_column($usersId, 'user_id');

        return $this->select($tableFields)->whereNotIn('id', $usersId)->findAll();
    }

    public function getCandidate(int $id)
    {

        $tableFields = [
            'id',
            'name',
            'email',
            'is_active',
            'created_at',
            'updated_at',
            'email_verified_at',
        ];

        $usersId = $this->db->table('users_admin')->get()->getResult();
        $usersId = array_column($usersId, 'user_id');

        $this->whereNotIn('id', $usersId);

        $candidate = $this->select($tableFields)->find($id);

        if (!is_null($candidate)) {

            $candidate->applications = Factories::models(ApplicationModel::class)->applications($candidate->id);
        }

        return $candidate;
    }

    public function disablePasswordValidation()
    {
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }

    public function deleteCandidate(int|array $idToDelete)
    {
        if (is_int($idToDelete)) {

            return $this->delete($idToDelete);
        }

        // We guarantee that the admin id will not be deleted, since this area is accessed only by admin
        return $this->where('id !=', service('auth')->user()->id)->whereIn('id', $idToDelete)->delete();
    }
}
