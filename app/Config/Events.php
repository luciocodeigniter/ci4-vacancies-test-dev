<?php

namespace Config;

use App\Notifications\Notify;
use CodeIgniter\Config\Factories;
use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function () {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static function ($buffer) {
            return $buffer;
        });
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && !is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        Services::toolbar()->respond();
    }


    /**
     * Send e-mail with link to activate account
     */
    Events::on('notify_activation_email', function ($email, $token) {

        Factories::class(Notify::class)->sendEmailActivation($email, $token);
    });


    /**
     * Send e-mail with link to password recovery
     */
    Events::on('send_recovery_email', function ($email, $token) {

        Factories::class(Notify::class)->sendEmailPasswordRecovery($email, $token);
    });


    /**
     * Resend e-mail with link to activate account
     */
    Events::on('notify_resend_activation_email', function ($email, $token) {

        Factories::class(Notify::class)->resendEmailActivation($email, $token);
    });
});
