<?php

namespace App\Http\Controllers\Affiliator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prospect;
use App\Models\User;

class ProspectController extends Controller
{
    /**
     * Display the tracking list (Daftar Mahasiswa Saya)
     */
    public function index()
    {
        $affiliator = Auth::user();

        // 1. Get Manual Prospects
        $manualProspects = Prospect::where('affiliator_id', $affiliator->id)
            ->where('status', 'prospek')
            ->get()
            ->map(function ($prospect) {
                return (object) [
                    'source' => 'manual',
                    'name' => $prospect->name,
                    'whatsapp' => $prospect->whatsapp,
                    'program' => $prospect->program_interest ?? '-',
                    'status_label' => 'PROSPEK',
                    'status_color' => 'secondary',
                    'created_at' => $prospect->created_at,
                ];
            });

        // 2. Get Link Registrants (Draft/Pending/Active - Affiliator Recruits)
        $linkRegistrants = User::where('referred_by', $affiliator->id)
            ->whereHas('role', function($q){ $q->where('name', 'affiliator'); })
            ->with('registration')
            ->get()
            ->map(function ($user) {
                $statusLabel = 'TERDAFTAR';
                $statusColor = 'primary';
                $program = 'Program Afiliasi';

                // Map registration and user status to simplified tracking status
                if ($user->status === 'active') {
                    $statusLabel = 'BAYAR (Aktif)';
                    $statusColor = 'success';
                } elseif ($user->registration && $user->registration->status === 'pending') {
                    $statusLabel = 'TERDAFTAR';
                    $statusColor = 'primary';
                }

                return (object) [
                    'source' => 'link',
                    'name' => $user->name,
                    'whatsapp' => $user->whatsapp ?? '-',
                    'program' => $program,
                    'status_label' => $statusLabel,
                    'status_color' => $statusColor,
                    'created_at' => $user->created_at,
                ];
            });

        // Merge and sort by newest
        $students = $manualProspects->concat($linkRegistrants)->sortByDesc('created_at');

        return view('affiliator.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new prospect manually.
     */
    public function create()
    {
        return view('affiliator.students.create');
    }

    /**
     * Store a newly created prospect in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|numeric',
            'school_origin' => 'nullable|string|max:255',
            'program_interest' => 'nullable|string',
        ]);

        Prospect::create([
            'affiliator_id' => Auth::id(),
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'school_origin' => $request->school_origin,
            'program_interest' => $request->program_interest,
            'status' => 'prospek',
        ]);

        return redirect()->route('affiliator.students.index')->with('success', 'Data Prospek berhasil ditambahkan.');
    }
}
