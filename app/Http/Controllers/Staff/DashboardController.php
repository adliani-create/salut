<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if tables exist to avoid crash if migration hasn't run
        try {
            $pendingValidations = \App\Models\Registration::where('status', 'pending')->count();
            $openTickets = \App\Models\SupportTicket::where('status', 'open')->count();
        } catch (\Exception $e) {
            $pendingValidations = 0;
            $openTickets = 0;
        }
        
        $user = auth()->user();

        return view('staff.home', compact('pendingValidations', 'openTickets', 'user'));
    }
}
