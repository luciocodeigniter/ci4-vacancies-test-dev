<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Events\Events;

use function PHPUnit\Framework\returnSelf;

class Password extends BaseController
{

    public function __construct()
    {
        $this->userModel = Factories::models(UserModel::class);
    }

    public function index()
    {
        $data = [
            'title' => 'Iniciar Recuperação de Senha'
        ];

        return view('Password/index', $data);
    }

    public function recovery()
    {

        // Validate de request
        if (!$this->validate(['email' => 'required|valid_email'])) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->validator->getErrors())
                ->withInput();
        }


        // Try to get user from e-mail
        $user = $this->userModel->getByCriteria(['email' => $this->request->getPost('email')]);

        // Did we find or is active?
        if (is_null($user) || !$user->is_active) {

            return redirect()->back()->with('danger', 'Não encontramos uma conta válida com esse e-mail')->withInput();
        }

        // Good! Now we can start password recovery
        $user->startPasswordReset();

        // Did we saved model user?
        if (!$this->userModel->save($user)) {

            return redirect()->back()->with('danger', 'Não conseguimos prosseguir com a recuperação da senha. Acione o nosso suporte');
        }

        Events::trigger('send_recovery_email', $user->email, $user->token);

        return redirect()->route('password.reset.send')->with('succes', 'Enviamos para a sua caixa de entrada o link para iniciar a recuperação da senha');
    }


    public function resetSend()
    {
        $data = [
            'title' => 'Enviamos para a sua caixa de entrada o link para iniciar a recuperação da senha'
        ];

        return view('Password/reset_send', $data);
    }

    public function reset(string $token = null)
    {
        // Try get the user
        $user = $this->userModel->getUserForPasswordReset($token);

        // Did we find?
        if (is_null($user)) {

            return redirect()->route('password')->with('danger', 'Link de recuperação está inválido ou expirado');
        }

        // Nice! We can show a view to create a new password.

        $data = [
            'title' => 'Crie uma nova senha',
            'token' => $token
        ];

        return view('Password/reset', $data);
    }

    public function create(string $token)
    {

        $rules = [
            'password' => 'required|min_length[6]',
            'password_confirmation' => 'required|matches[password]',
        ];

        $messages = $this->userModel->getValidationMessages();

        // Validate de request
        if (!$this->validate($rules, $messages)) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->validator->getErrors())
                ->withInput();
        }

        // Try get user again
        $user = $this->userModel->getUserForPasswordReset($token);

        // Did we find?
        if (is_null($user)) {

            return redirect()->route('password')->with('danger', 'Link de recuperação está inválido ou expirado');
        }

        // Fill only password
        $user->password = $this->request->getPost('password');

        // Set de property null
        $user->completePasswordReset();

        // Did we saved model user?
        if (!$this->userModel->save($user)) {

            return redirect()->route('login')->with('danger', 'Não conseguimos prosseguir com a criação da nova senha. Acione o nosso suporte');
        }

        // Yes! We did
        return redirect()->route('login')->with('success', 'Sua senha foi criada com sucesso!');
    }
}
