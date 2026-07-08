<?php

use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\ShareSiteData;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(SecurityHeaders::class);
        $middleware->web(append: [ShareSiteData::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        /**
         * The branded errors/{403,404,500,503} views extend the public
         * site's layout, which reads settings shared by ShareSiteData —
         * middleware that only runs on the 'web' group, deliberately not
         * applied to the Filament panel. Rendering those views for an
         * admin-panel error would crash on the missing shared data, so
         * admin requests fall back to a bare status response instead.
         */
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            $adminPath = config('admin.path');

            if ($request->is($adminPath, "{$adminPath}/*")) {
                return response(null, $e->getStatusCode(), $e->getHeaders());
            }
        });
    })->create();
