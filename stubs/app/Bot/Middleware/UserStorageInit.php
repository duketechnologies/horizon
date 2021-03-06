<?php

namespace App\Bot\Middleware;

use App\Models\UserStorage;
use Closure;
use Illuminate\Http\Request;

class UserStorageInit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        UserStorage::firstOrCreate([
            'telegram_id' => chat_id()
        ]);

        return $next($request);
    }
}
