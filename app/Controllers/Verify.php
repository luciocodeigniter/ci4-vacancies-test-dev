<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Events\Events;

class Verify extends BaseController
{

    public function __construct()
    {
        $this->user = service('auth')->user();
        $this->userModel = Factories::models(UserModel::class);
    }

    public function index()
    {
        $data = [
            'title' => 'Verificação de conta',
        ];

        return view('Verify/index', $data);
    }


    public function resend()
    {
        // Initiate the activation
        $this->user->startActivation();

        $this->userModel->save($this->user);

        // Resend e-mail activation
        Events::trigger('notity_resend_activation_email', $this->user->email, $this->user->token);

        return redirect()->back()->with('success', "Enviamos para o seu email {$this->user->email} o link para que você possa ativar a sua conta.");
    }

    public function activate(string $token = null)
    {
        if (!$this->userModel->activateByToken($token)) {

            return redirect()->route('login')->with('danger', 'Não conseguimos ativar a sua conta. Por favor entre em contato com nosso suporte');
        }

        return redirect()->route('jobs.my')->with('success', 'Sua conta foi ativada com sucesso');
    }
}
