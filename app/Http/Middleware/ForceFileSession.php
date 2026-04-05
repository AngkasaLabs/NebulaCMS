<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceFileSession
{
    public function handle(Request $request, Closure $next): Response
    {
        config([
            'session.driver' => 'file',
            'session.files' => storage_path('framework/sessions'),
        ]);

        return $next($request);
    }
}
