<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is logged in, is 'mahasiswa', and has registration with status 'draft'
        if ($user && $user->role && $user->role->name === 'mahasiswa') {
            
            // If user has no registration at all, or status is draft/incomplete
            if (!$user->registration || $user->registration->status === 'draft') {
                
                // Allow them to access the step 2 and step 3 route and logout, but block others
                if (!$request->routeIs('register.step2') && 
                    !$request->routeIs('register.step2.store') && 
                    !$request->routeIs('register.step3') && 
                    !$request->routeIs('register.step3.store') && 
                    !$request->routeIs('logout') && 
                    !$request->routeIs('api.prodi-by-fakultas')) {
                    
                    if ($user->registration->fokus_karir) {
                        return redirect()->route('home'); // Already done?
                    }
                    if ($user->registration->jenjang) {
                         // Step 2 done, go to step 3
                         return redirect()->route('register.step3');
                    }
                    
                    return redirect()->route('register.step2');
                }
            }
        }

        return $next($request);
    }
}
