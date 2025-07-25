<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGroupAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$is_admin): Response
    {

        $user = auth()->user();
        $isAdmin = $user->groups()->where('user_id', $user->id)->value('is_admin');
        if ($isAdmin==$is_admin||auth()->user()->role_id==2||auth()->user()->role_id==1)
        {
            return $next($request);
        } else {
            abort(403, 'anAuth');
        }
    }
}
