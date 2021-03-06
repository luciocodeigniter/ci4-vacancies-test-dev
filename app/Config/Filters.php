<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,

        'auth'  =>  [
            \App\Filters\AuthFilter::class,
        ],

        'verified'  =>  [
            \App\Filters\AuthFilter::class,
            \App\Filters\VerifiedFilter::class,
        ],

        'admin'  =>    [
            \App\Filters\AuthFilter::class,
            \App\Filters\AdminFilter::class
        ],

        'guest' => \App\Filters\GuestFilter::class,

        'candidate'  =>    [
            \App\Filters\AuthFilter::class,
            \App\Filters\CandidateFilter::class,
        ],


        'throttle' => \App\Filters\ThrottleFilter::class,

        // API
        'api_auth'      => \App\Filters\API\AuthFilter::class,
        'api_verified'  => \App\Filters\API\VerifiedFilter::class,
        'api_admin'     => \App\Filters\API\AdminFilter::class,

    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'honeypot',
            'csrf' => ['except' => 'api/*'],
            'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [
        'post' => ['throttle']
    ];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
