<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        // Check if user has a role and if that role name is in the allowed list
        if ($user->role && in_array($user->role->name, $roles)) {
            return $next($request);
        }

        return redirect('/home')->with('error', 'Unauthorized access.');
    }
}
