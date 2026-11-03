<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //mendaftarkan middleware agar bisa di gunakanp
        // mendaftarkan middleware biar si app namain dia isAdmin dan biar ga manggil panjang
        $middleware->alias([
            'IsLoggedIn' => App\http\Middleware\IsLoggedIn::class,
            'IsGuest' => App\http\Middleware\IsGuest::class,
            'isAdmin' => App\Http\Middleware\isAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
