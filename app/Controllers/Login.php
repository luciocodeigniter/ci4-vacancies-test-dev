<?php

namespace App\Controllers;

use App\Controllers\BaseController;



class Login extends BaseController
{
    public function __construct()
    {
        $this->auth = service('auth');
    }

    public function index()
    {

        $data = ['title' => 'Realize o login'];

        return view('Login/index', $data);
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
                ->withCookies();
        }

        return redirect()->back()->with('danger', 'Sua conta não foi encontrada ou ainda não foi verificada')
            ->withInput();
    }


    public function destroy()
    {
        $this->auth->logout();

        return redirect()->route('home')->withCookies();
    }
}
