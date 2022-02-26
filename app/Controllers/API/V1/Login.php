<?php

namespace App\Controllers\API\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->userModel = Factories::models(UserModel::class);
    }

    public function index()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        if (!$this->validate(['email' => 'required|valid_email', 'password' => 'required'])) {

            return $this->failValidationErrors($this->validator->getErrors());
        }

        if (!$accessToken = service('auth')->attemptCreateJWT($email, $password)) {

            return $this->fail('Check your login credentials and try again');
        }

        $response = [
            'message'       => 'Login Succesful',
            'access_token'  => $accessToken
        ];

        return $this->respond($response, 200);
    }
}
