<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $mitra = Auth::user();

        // 1. Total Affiliator (Direct referrals)
        $totalAffiliators = User::where('referred_by', $mitra->id)
            ->whereHas('role', function($q) { $q->where('name', 'affiliator'); })
            ->count();

        // 2. Team Statistics (Total Mahasiswa & Top Affiliators)
        $teamStats = User::where('referred_by', $mitra->id)
            ->whereHas('role', function($q) { $q->where('name', 'affiliator'); })
            ->withCount(['referrals as students_count' => function ($query) {
                $query->whereHas('role', function ($q) {
                    $q->where('name', 'mahasiswa');
                });
            }])
            ->get();

        $totalStudentsFromTeam = $teamStats->sum('students_count');
        
        // Sort for leaderboard
        $teamStats = $teamStats->sortByDesc('students_count')->take(5);

        // 3. Total Points
        $totalPoints = $mitra->total_points ?? collect($mitra->pointLedgers)->sum(function ($ledger) {
            return $ledger->type === 'credit' ? $ledger->amount : -$ledger->amount;
        });

        // 4. Referral Link calculation (For Mahasiswa)
        $referralLink = url('/register?ref=' . $mitra->referral_code);
        
        // 4b. Referral Link calculation (For Affiliator)
        $affiliateReferralLink = url('/register/affiliator?ref=' . $mitra->referral_code);

        // 5. Recent affiliators joined
        $recentAffiliators = User::where('referred_by', $mitra->id)
            ->whereHas('role', function($q) { $q->where('name', 'affiliator'); })
            ->latest()
            ->take(5)
            ->get();

        return view('mitra.dashboard', compact(
            'totalAffiliators', 
            'totalStudentsFromTeam',
            'teamStats',
            'totalPoints',
            'referralLink',
            'affiliateReferralLink',
            'recentAffiliators'
        ));
    }
}
