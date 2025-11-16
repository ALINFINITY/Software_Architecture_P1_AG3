<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Activar autenticación de Sanctum para APIs stateful
        $middleware->statefulApi();

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 401 - No autenticado (evita redirección a ruta 'login')
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        });

        // 403 - No autorizado
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            return response()->json(['message' => 'No autorizado'], 403);
        });

        // 404 - Ruta o recurso no encontrado
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json(['message' => 'Ruta no encontrada'], 404);
        });
    })->create();
