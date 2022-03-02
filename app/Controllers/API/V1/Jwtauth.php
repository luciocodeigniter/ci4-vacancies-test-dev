<?php

namespace App\Controllers\API\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Events\Events;
use App\Entities\User;

class Jwtauth extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->userModel = Factories::models(UserModel::class);
        $this->auth = service('auth');
    }

    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        if (!$this->validate(['email' => 'required|valid_email', 'password' => 'required'])) {

            return $this->failValidationErrors($this->validator->getErrors());
        }

        if (!$accessToken = $this->auth->attemptCreateJWT($email, $password)) {

            return $this->fail('Check your login credentials and try again');
        }

        return $this->respondWithToken($accessToken);
    }


    public function register()
    {
        $user = new User([
            'name'                      => $this->request->getPost('name'),
            'email'                     => $this->request->getPost('email'),
            'password'                  => $this->request->getPost('password'),
            'password_confirmation'     => $this->request->getPost('password_confirmation'),
        ]);

        // Initiate the activation
        $user->startActivation();

        if (!$this->userModel->insert($user)) {

            return $this->failValidationErrors($this->userModel->errors());
        }

        // Since the user was created, now we can send email activation
        Events::trigger('notity_activation_email', $user->email, $user->token);


        $response = [
            'status'    => 201,
            'message'   => "Account created successfully! We have sent the link to your email {$user->email} so that you can activate your account."
        ];

        return $this->respondCreated($response);
    }

    public function user()
    {
        if (!$user = $this->auth->attemptValidateJWT($this->request)) {

            return $this->failUnauthorized('You are not logged in');
        }

        $response = [
            'status'    => 200,
            'user'      => $user
        ];

        return $this->respond($response);
    }


    protected function respondWithToken($accessToken)
    {
        $response = [
            'message'       => 'Login Succesful',
            'access_token'  => $accessToken,
            'token_type'    => 'bearer',
        ];

        return $this->respond($response, 200);
    }
}
