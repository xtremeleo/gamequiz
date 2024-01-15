<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class ActiveUser
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
		$logged_user = Auth::user();
		
		if ($logged_user->status == "INACTIVE")
		{
			return redirect()->route('verify.needed');
		}
		
        return $next($request);
    }
}
