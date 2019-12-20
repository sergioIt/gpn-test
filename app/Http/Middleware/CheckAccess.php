<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * слой для проверки токена
 *
 */
class CheckAccess
{
    // фейковый токен
    protected $token = '123aab';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // @todo проверять токен с тем, что есть в сессии

        return $next($request);
    }
}
