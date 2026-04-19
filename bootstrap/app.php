<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
       $middleware->redirectGuestsTo(function ($request) {
        // فحص المسار لتحديد الـ Guard المناسب
        if ($request->is('cms/admin*')) {
            return route('view.login', ['guard' => 'admin']);
        }

        if ($request->is('cms/team*')) {
            return route('view.login', ['guard' => 'team']);
        }

        if ($request->is('cms/artisan*')) {
            return route('view.login', ['guard' => 'artisan']);
        }

        if ($request->is('cms/customer*')) {
            return route('view.login', ['guard' => 'customer']);
        }

        // المسار الافتراضي إذا لم يتطابق شيء (مثلاً صفحة دخول المستخدمين العاديين)
       return route('view.login', ['guard' => 'admin']);
    });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
