<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Auth;
use CodeIgniter\Config\Factories;

class Login extends BaseController
{

    public function __construct()
    {
        $this->auth = Factories::class(Auth::class);
    }

    public function index()
    {

        return view('Login/index');
    }

    public function create()
    {

        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required',
        ])) {

            return redirect()->back()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errors_model', $this->validator->getErrors())
                ->withInput();
        }

        $request = (object) $this->request->getPost();

        $email      = $request->email;
        $password   = $request->password;
        $rememberMe   = (bool) isset($request->remember_me);

        if ($this->auth->login($email, $password, $rememberMe)) {

            return redirect()->route('home')
                ->with('success', 'Login realizado com sucesso')
                ->withCookies(); // withCookies só fazer depois do módulo User completo
        }

        return redirect()->back()->with('danger', 'Verifique suas credenciais e tente novamente')->withInput();
    }


    public function destroy()
    {
        return redirect()->route('home')->withCookies(); // Essa parte foi feita após o Módulo User completo
    }
}
