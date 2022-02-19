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
        $user = new User([
            'name'                      => $this->request->getPost('name'),
            'email'                     => $this->request->getPost('email'),
            'password'                  => $this->request->getPost('password'),
            'password_confirmation'     => $this->request->getPost('password_confirmation'),
        ]);

        // Initiate the activation
        $user->startActivation();

        if (!$this->userModel->insert($user)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->userModel->errors())
                ->withInput();
        }

        // Since the user was created, now we can send email activation
        Events::trigger('notity_activation_email', $user->email, $user->token);


        return redirect()->route('register.success')->with('success', "Conta criada com sucesso! <br>Enviamos para o seu email {$user->email} o link para que você possa ativar a sua conta.");
    }


    public function success()
    {
        $data = ['title' => 'Enviamos para o seu e-mail o link de ativação da conta'];

        return view('Register/success', $data);
    }
}
