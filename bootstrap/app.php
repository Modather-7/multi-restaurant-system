<?php

use App\Exceptions\InvalidOrderException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\UpdateUserLastActiveAt::class,
            \App\Http\Middleware\MarkNotificationAsRead::class,
        ]);

        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            return '/';
        });

        $middleware->redirectUsersTo(function ($request) {
            if (auth('admin')->check()) {
                return route('dashboard.dashboard');
            }
            return route('profile.edit');
        });

        $middleware->alias([
            'branch.selected' => \App\Http\Middleware\EnsureBranchSelected::class,
            'auth.type' => \App\Http\Middleware\CheckUserType::class,
            'set.locale' => \App\Http\Middleware\SetAppLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // dashboard exceptions
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($e->getCode() == 23000) {
                $message = 'Foreign key constraint failed';
            } else {
                $message = $e->getMessage();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                ], 400);
            }

            return redirect()
                ->back()
                ->withInput()->withErrors([
                    'message' => $e->getMessage(),
                ])
                ->with('info', $message);
        });

        // front exception
        $exceptions->render(function (InvalidOrderException $e, Request $request) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        });
    })->create();
