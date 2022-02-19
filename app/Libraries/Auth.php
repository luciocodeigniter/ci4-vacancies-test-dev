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

        $this->remeberModel = Factories::models(RememberedLoginModel::class);

        $this->user = null;
    }

    public function login(string $email, string $password, bool $rememberMe = false): bool
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

    public function user(): null|User
    {
        // The property still null?
        if (is_null($this->user)) {

            // Try get the user from session
            $this->user = $this->getUserFromSession();
        }


        // The property still null?
        if (is_null($this->user)) {

            // Try get the user from cookie
            $this->user = $this->getUserFromCookie();
        }

        return $this->user;
    }

    public function isLoggedIn(): bool
    {
        // Is anyone in the session?
        return !is_null($this->user());
    }

    public function logout(): void
    {

        // Try to get the cookie 'remember_me'
        $token = service('request')->getCookie('remember_me');

        // Did we find?
        if (!is_null($token)) {

            // We remove from de database
            $this->remeberModel->deleteByToken($token);


            // We remove cookie 
            service('response')->deleteCookie('remember_me');
        }


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

    private function getUserFromCookie(): null|User
    {

        // Access the request service
        $request = service('request');

        // Try to get de cookie 'remember_me'
        $token = $request->getCookie('remember_me');

        // Did we find?
        if (is_null($token)) {

            return null;
        }

        // Try find user by remeber token
        $rememberedLogin = $this->remeberModel->findByToken($token);


        // Did we find?
        if (is_null($rememberedLogin)) {

            return null;
        }


        // Try to get the user
        $user = $this->userModel->getByCriteria(['id' => $rememberedLogin->user_id]);

        // Still exists and is active?
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

    private function rememberLogin(int $userId): void
    {
        // Generate the token cookie
        list($token, $expiry) = $this->remeberModel->rememberUserLogin($userId);

        // Set de cookie on the response
        service('response')->setCookie('remember_me', $token, $expiry);
    }
}
