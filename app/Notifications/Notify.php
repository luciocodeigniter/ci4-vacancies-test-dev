<?php

namespace App\Notifications;


class Notify
{
    public function __construct()
    {
        $this->service = service('email');
    }

    public function sendEmailActivation(string $email, string $token)
    {
        $this->service->setFrom('no-reply@vacancies.com', 'Codeigniter 4 - Vacancies - Test - Dev');
        $this->service->setTo($email);
        $this->service->setSubject('Ativação de conta');

        $message = view('Register/activation_email', ['token' => $token]);

        $this->service->setMessage($message);

        if (!$this->service->send()) {

            log_message('error', $this->service->printDebugger());

            return false;
        }

        return true;
    }
}
