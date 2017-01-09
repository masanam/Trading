<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use App\Model\User;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::first();
        if($user->isAdmin() > -1) {
            return $next($request);
        }

        return response()->json('Unauthorized', 401);
    }
}
