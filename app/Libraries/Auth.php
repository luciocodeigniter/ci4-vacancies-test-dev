<?php

namespace App\Libraries;

use App\Models\UserModel;
use CodeIgniter\Config\Factories;
use App\Entities\User;

class Auth
{
    public function __construct()
    {
        $this->userModel = Factories::models(UserModel::class);

        $this->user = null;
    }

    public function login(string $email, string $password, bool $rememberMe): bool
    {
        // Try get the user
        $user = $this->userModel->getByCriteria(['email' => $email]);


        // Was found or is active?
        if (is_null($user) || !$user->is_active) {

            return false;
        }



        // Password is valid?
        if (!$user->validatePassword($password)) {
            return false;
        }


        // let the user in
        $this->letTheUserIn($user);

        if ($rememberMe) {

            $this->rememberLogin($user->id);
        }

        // Finally logged
        return true;
    }

    public function getLoggedUser(): null|User
    {
        // The property still null?
        if (is_null($this->user)) {

            // Try get the user from session
            $this->user = $this->getUserFromSession();
        }

        return $this->user;
    }

    public function isLoggedIn(): bool
    {
        // Is anyone in the session?
        return !is_null($this->getLoggedUser());
    }

    public function logout(): void
    {
        session()->destroy();
    }

    private function getUserFromSession(): null|User
    {
        // There is a key 'user_id' in session?
        if (!session()->has('user_id')) {

            return null;
        }

        // Try get the user
        $user = $this->userModel->getByCriteria(['id' => session('user_id')]);

        // Was found or still is active?
        if (is_null($user) || !$user->is_active) {

            return null;
        }

        // The logged user is admin?
        $user->is_admin = $this->isAdmin($user->id);


        return $user;
    }

    private function getUserFromRememberCookie()
    {

        /**
         * Para recuperarmos o cookie precisamos de um objeto request.
         * Faremos isso utilizando o helper service
         */
        $request = service('request');

        /**
         * Recuperando o cookie
         */
        $token = $request->getCookie('remember_me');

        /**
         * Se não exitir um cookie chamado 'remember_me', será retornado null
         */
        if (is_null($token)) {

            return null;
        }


        $remeberModel = Factories::models(RememberedLoginModel::class);

        $rememberedLogin = $remeberModel->findByToken($token);

        if (is_null($rememberedLogin)) {

            return null;
        }

        /*
         * ---------------------------------------------------------------
         */

        /*
         * A partir desse ponto, nós já conseguimos recuperar o usuário a partir do objeto $remembered_login
         * que contém o atributo 'user_id'
         */

        $user = $this->userModel->getByCriteria(['id' => $rememberedLogin->user_id]);

        /**
         * Se foi encontrado um user e o mesmo está ativo, setamos o id do mesmo chamado o método logInUser($user)
         * e retornamos o objeto $user
         */
        if ($user && $user->is_active) {

            $this->letTheUserIn($user);

            return $user;
        }
    }

    private function letTheUserIn(User $user): void
    {
        // Generate a new session ID before log in the user
        session()->regenerate();

        session()->set('user_id', $user->id);
    }

    private function isAdmin(int $userId): bool
    {
        return $this->userModel->isAdmin($userId);
    }

    private function rememberLogin(int $userId)
    {

        $remeberModel = Factories::models(RememberedLoginModel::class);

        list($token, $expiry) = $remeberModel->rememberUserLogin($userId);

        /**
         * Setando cookie
         */
        service('response')->setCookie('remember_me', $token, $expiry);
    }
}
