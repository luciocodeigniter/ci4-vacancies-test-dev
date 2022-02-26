<?php

namespace App\Controllers\API\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Events\Events;

class Register extends ResourceController
{

    public function __construct()
    {
        $this->userModel = Factories::models(UserModel::class);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
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
}
