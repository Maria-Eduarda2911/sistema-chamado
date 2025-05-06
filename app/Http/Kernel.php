<?php

namespace App\Http;

class Kernel
{
    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            // ...
            \App\Http\Middleware\VerifyCsrfToken::class,
            // ...
        ],
    ];
}
