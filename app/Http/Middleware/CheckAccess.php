<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\UnauthorizedException;

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

        if(! $token = $request->get('token')){

            throw  new \InvalidArgumentException('missed token param');
        }

        if(! Cache::has($token)){

            throw new UnauthorizedException('token mismatch');
        }


        return $next($request);
    }
}
