<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Support\Core\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../src/App/Web/routes/routes.php',
        api: __DIR__.'/../src/App/Api/routes/routes.php',
        commands: __DIR__.'/../src/App/Console/routes/routes.php',
        health: '/up',
    )
    ->withCommands([
        __DIR__.'/../src/App/Console/Commands',
    ])
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
