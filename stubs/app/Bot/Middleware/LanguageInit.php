<?php

namespace App\Bot\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageInit
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = user_storage()->get('lang') ?? 'ru';
        app()->setLocale($lang);

        return $next($request);
    }
}
