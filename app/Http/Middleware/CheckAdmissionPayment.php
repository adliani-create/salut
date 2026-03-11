<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmissionPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if user is logged in, is a student, and has unpaid/pending status
        if ($user && $user->role->name === 'mahasiswa' && in_array($user->status, ['unpaid', 'pending_verification'])) {
            // Prevent redirect loops by checking if they are already on the admission routes or logging out
            if (!$request->routeIs('student.admission.pay') && !$request->routeIs('student.admission.upload') && !$request->routeIs('logout')) {
                return redirect()->route('student.admission.pay');
            }
        }

        return $next($request);
    }
}
