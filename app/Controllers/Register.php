<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Events\Events;

class Register extends BaseController
{

    public function __construct()
    {
        $this->userModel = Factories::models(UserModel::class);
    }

    public function index()
    {

        $data = ['title' => 'Criar conta'];

        return view('Register/index', $data);
    }


    public function create()
    {
        $rules = $this->userModel->getValidationRules();

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->validator->getErrors())
                ->withInput();
        }

        // Create the user
        $user = self::createUser($this->request);

        // Let the user in
        service('auth')->login($user);

        return redirect()->route('home')->withCookies();
    }


    public function activate(string $token = null)
    {
        if (!$this->userModel->activateByToken($token)) {

            return redirect()->route('login')->with('danger', 'Não conseguimos ativar a sua conta. Por favor entre em contato com nosso suporte');
        }

        return redirect()->route('login')->with('success', 'Sua conta foi ativada com sucesso');
    }

    private function createUser($request)
    {

        $user = new User([
            'name'                      => $request->getPost('name'),
            'email'                     => $request->getPost('email'),
            'password'                  => $request->getPost('password'),
            'password_confirmation'     => $request->getPost('password_confirmation'),
            'is_active'                 => true
        ]);

        // Initiate the activation
        $user->startActivation();

        // Get the generated token
        $token = $user->token;

        // Unset de the generated token before insert
        unset($user->token);

        $id = $this->userModel->protect(false)->insert($user);

        $user = $this->userModel->getByCriteria(['id' => $id]);

        // Since the user was created, now we can send email activation
        Events::trigger('notify_activation_email', $user->email, $token);

        return $user;
    }
}
