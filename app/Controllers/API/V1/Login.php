<?php

namespace App\Controllers\API\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use \Firebase\JWT\JWT;


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

        $user = $this->userModel->getByCriteria(['email' => $email]);

        if (is_null($user)) {

            return $this->fail('Check your login credentials and try again');
        }

        if (!$user->validatePassword($password)) {

            return $this->fail('Check your login credentials and try again');
        }

        $response = [
            'message'       => 'Login Succesful',
            'access_token'  => $this->generateJWT($user->email)
        ];

        return $this->respond($response, 200);
    }

    private function generateJWT(string $email)
    {
        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $email,
        );

        $token = JWT::encode($payload, $key, 'HS256');

        return $token;
    }
}
