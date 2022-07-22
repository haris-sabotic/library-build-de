<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectUser
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
        //check if user is banned, if is banned and loged in, then logut him and show message with details
        if (Auth::check() && Auth::user()->userType->name == "student") {
            auth()->logout();

            $message = 'Pristup ucenika jos uvijek nije moguc. Probajte kasnije!';

            return redirect()->route('login')->withMessage($message);
        }
        return $next($request);
    }
}
