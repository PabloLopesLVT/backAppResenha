<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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

        if(isset(auth()->user()->is_admin)){


            if (auth()->user()->is_admin == 1) {

            } else {
                abort(403, 'Acesso não autorizado');
            }

        }else{
            return $next($request);
        }

    }
}
