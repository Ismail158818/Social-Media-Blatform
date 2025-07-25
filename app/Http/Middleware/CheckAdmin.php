<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        if (!auth()->check()) {

            abort(403, 'Unauthorized');
        }
    
        $user = auth()->user();
    
        // تأكد إنه عنده علاقة role وموجودة فعلاً
        if ($user->role && in_array($user->role->id, $role)) {
            return $next($request);
        }
    
        abort(403, 'Unauthorized');
    }
    
}
