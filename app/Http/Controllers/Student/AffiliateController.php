<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Prospect;
use App\Models\CareerProgram;

class AffiliateController extends Controller
{
    /**
     * Show Affiliate Dashboard or Landing Page
     */
    public function index()
    {
        $user = Auth::user();

        // If not an affiliate yet, show landing page
        if (!$user->is_affiliator) {
            return view('mahasiswa.affiliate.landing');
        }

        // --- DASHBOARD LOGIC (Same as Affiliator Role) ---
        // 1. Ensure referral code exists
        if (empty($user->referral_code)) {
            $user->referral_code = $this->generateReferralCode($user);
            $user->save();
        }

        // 2. Fetch Prospects (Manual Input)
        $manualProspects = Prospect::where('affiliator_id', $user->id)
            ->where('status', 'prospek')
            ->get()
            ->map(function ($prospect) {
                return (object) [
                    'source' => 'manual',
                    'name' => $prospect->name,
                    'whatsapp' => $prospect->whatsapp,
                    'program' => $prospect->program_interest ?? 'Belum ditentukan',
                    'created_at' => $prospect->created_at,
                    'status_label' => 'PROSPEK',
                    'status_color' => 'warning'
                ];
            });

        // 3. Fetch Registered Users via Link
        $registeredUsers = User::where('referred_by', $user->id)
            ->whereHas('role', function($q){
                $q->where('name', 'mahasiswa');
            })
            ->get()
            ->map(function ($regUser) {
                $statusLabel = 'PROSPEK';
                $statusColor = 'warning';

                if ($regUser->status === 'active') {
                    $statusLabel = 'AKTIF / LUNAS';
                    $statusColor = 'success';
                } elseif ($regUser->status === 'pending_payment') {
                    $statusLabel = 'TERDAFTAR';
                    $statusColor = 'info';
                }

                return (object) [
                    'source' => 'link',
                    'name' => $regUser->name,
                    'whatsapp' => $regUser->whatsapp ?? '-',
                    'program' => optional($regUser->registration)->fokus_karir ?? 'Belum ditentukan',
                    'created_at' => $regUser->created_at,
                    'status_label' => $statusLabel,
                    'status_color' => $statusColor
                ];
            });

        // Merge and sort
        $students = $manualProspects->concat($registeredUsers)->sortByDesc('created_at');
        
        // Stats
        $totalPoints = $user->total_points ?? collect($user->pointLedgers)->sum(function ($ledger) {
            return $ledger->type === 'credit' ? $ledger->amount : -$ledger->amount;
        });

        $referralLink = url('/register?ref=' . $user->referral_code);

        return view('mahasiswa.affiliate.dashboard', compact('user', 'students', 'totalPoints', 'referralLink'));
    }

    /**
     * Process registration as Affiliator
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if ($user->is_affiliator) {
            return redirect()->route('student.affiliate.index');
        }

        // Activate affiliate status
        $user->is_affiliator = true;
        
        // Generate code if not exist
        if (empty($user->referral_code)) {
            $user->referral_code = $this->generateReferralCode($user);
        }
        
        $user->save();

        return redirect()->route('student.affiliate.index')->with('success', 'Selamat! Anda kini tergabung dalam Program Afiliasi.');
    }

    /**
     * Show form to manually input prospects
     */
    public function createProspect()
    {
        if (!Auth::user()->is_affiliator) {
            return redirect()->route('student.affiliate.index');
        }
        
        $programs = CareerProgram::all();
        return view('mahasiswa.affiliate.create_prospect', compact('programs'));
    }

    /**
     * Store new prospect
     */
    public function storeProspect(Request $request)
    {
        if (!Auth::user()->is_affiliator) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'school_origin' => 'nullable|string|max:255',
            'program_interest' => 'nullable|string|max:255',
        ]);

        $validated['affiliator_id'] = Auth::id();
        $validated['status'] = 'prospek';

        Prospect::create($validated);

        return redirect()->route('student.affiliate.index')->with('success', 'Data prospek berhasil ditambahkan.');
    }

    /**
     * Helper to generate unique referral code
     */
    private function generateReferralCode($user)
    {
        // Format: MHS-SALUT-[3 letters of name]-[Random 4 digits]
        $namePart = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $user->name), 0, 3));
        $namePart = str_pad($namePart, 3, 'X'); 

        do {
            $code = 'MHS-SALUT-' . $namePart . '-' . rand(1000, 9999);
            $exists = User::where('referral_code', $code)->exists();
        } while ($exists);

        return $code;
    }
}
