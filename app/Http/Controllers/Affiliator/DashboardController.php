<?php

namespace App\Http\Controllers\Affiliator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Generate Referral Code if not exists
        if (empty($user->referral_code)) {
            $code = 'AFF-SALUT-' . strtoupper(Str::random(5));
            // Ensure uniqueness
            while (User::where('referral_code', $code)->exists()) {
                $code = 'AFF-SALUT-' . strtoupper(Str::random(5));
            }
            $user->update(['referral_code' => $code]);
        }

        $referralLink = url('/register?ref=' . $user->referral_code);

        // Fetch Stats
        $prospectsCount = \App\Models\Prospect::where('affiliator_id', $user->id)->count();
        
        $registeredStudentsCount = User::where('referred_by', $user->id)
            ->whereHas('role', function($q){ $q->where('name', 'mahasiswa'); })
            ->whereHas('registration', function($q){ $q->where('status', 'pending'); })
            ->count();
            
        $activeStudentsCount = User::where('referred_by', $user->id)
            ->whereHas('role', function($q){ $q->where('name', 'mahasiswa'); })
            ->where('status', 'active')
            ->count();

        // Total Points
        $totalPoints = $user->total_points ?? collect($user->pointLedgers)->sum(function ($ledger) {
            return $ledger->type === 'credit' ? $ledger->amount : -$ledger->amount;
        });

        return view('affiliator.dashboard', compact(
            'referralLink', 'prospectsCount', 'registeredStudentsCount', 'activeStudentsCount', 'totalPoints'
        ));
    }
}
