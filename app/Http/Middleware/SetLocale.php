<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED = ['en', 'id'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));

        if (in_array($locale, self::SUPPORTED, true)) {
            App::setLocale($locale);
        }

        // Ziggy reads URL defaults; routes with a `{locale}` segment need this for `route('home')` etc.
        URL::defaults(['locale' => App::getLocale()]);

        return $next($request);
    }
}
