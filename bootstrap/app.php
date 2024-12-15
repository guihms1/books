<?php

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $exception) {
            return redirect()->back()
                ->withErrors($exception->getErrors())
                ->withInput();
        });

        $exceptions->render(function (NotFoundException $exception) {
            return redirect(url()->previous())
                ->withErrors([$exception->getMessage()])
                ->withInput();
        });

        $exceptions->render(function (QueryException $exception) {
            Log::error($exception->getMessage());
            return redirect(url()->previous())
                ->withErrors(['Erro no banco de dados.'])
                ->withInput();
        });

        $exceptions->render(function (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('home')
                ->withErrors(['Oops... algo deu errado!'])
                ->withInput();
        });
    })->create();
