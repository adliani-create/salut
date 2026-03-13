<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PointLedger;
use Illuminate\Http\Request;

class AdmissionApprovalController extends Controller
{
    /**
     * Display a listing of students pending admission verification.
     */
    public function index()
    {
        $mahasiswaRoleId = \App\Models\Role::where('name', 'mahasiswa')->value('id');
        
        $pendingAdmissions = User::where('role_id', $mahasiswaRoleId)
                                 ->where('status', 'pending_verification')
                                 ->orderBy('updated_at', 'desc')
                                 ->get();

        return view('admin.admissions.index', compact('pendingAdmissions'));
    }

    /**
     * Display the specified admission receipt.
     */
    public function show(User $user)
    {
        // Ensure user is actually pending
        if ($user->status !== 'pending_verification') {
            return redirect()->route('admin.admissions.index')->with('error', 'Mahasiswa ini tidak dalam status menunggu verifikasi admisi.');
        }

        $user->load('registration');

        return view('admin.admissions.show', compact('user'));
    }

    /**
     * Approve the admission payment.
     */
    public function approve(Request $request, User $user)
    {
        if ($user->status !== 'pending_verification') {
            return back()->with('error', 'Status tidak valid untuk disetujui.');
        }

        $request->validate([
            'nim' => 'required|string|unique:users,nim,' . $user->id,
            'faculty' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'semester' => 'required|integer|min:1',
        ]);

        // 1. Activate Student + Assign Academic Data
        $user->status = 'active';
        $user->nim = $request->nim;
        $user->faculty = $request->faculty;
        $user->major = $request->major;
        $user->semester = $request->semester;
        $user->save();

        // 2. Update registration status to valid
        if ($user->registration) {
            $user->registration->update(['status' => 'valid']);
        }

        // 3. Grant Komisi to Referrer if exists
        $referrerId = $user->referred_by;
        if ($referrerId) {
            $referrer = User::find($referrerId);
            if ($referrer && $referrer->status === 'active') {
                $roleName = $referrer->hasRole('mitra') ? 'Mitra' : 'Affiliator';

                PointLedger::create([
                    'user_id' => $referrerId,
                    'amount' => 50000,
                    'type' => 'credit',
                    'source_id' => $user->id,
                    'description' => "Komisi Admisi Mahasiswa Baru ($roleName): " . $user->name,
                ]);

                // 4. Bonus Supervisi Mitra (if recruiter is affiliator under a mitra)
                if ($referrer->referred_by && $referrer->hasRole('affiliator')) {
                    $mitra = User::find($referrer->referred_by);
                    if ($mitra && $mitra->hasRole('mitra') && $mitra->status === 'active') {
                        PointLedger::create([
                            'user_id' => $mitra->id,
                            'amount' => 10000,
                            'type' => 'credit',
                            'source_id' => $user->id,
                            'description' => "Bonus Supervisi Admisi dari Tim ({$referrer->name}): " . $user->name,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.admissions.index')->with('success', 'Pembayaran Admisi disetujui. NIM ' . $request->nim . ' telah diberikan. Mahasiswa sekarang berstatus Aktif.');
    }

    /**
     * Reject the admission payment (optional fallback).
     */
    public function reject(Request $request, User $user)
    {
        if ($user->status !== 'pending_verification') {
            return back()->with('error', 'Status tidak valid untuk ditolak.');
        }

        // Revert back to unpaid so they can upload again
        $user->status = 'unpaid';
        // Optionally delete the old receipt
        // if ($user->admission_receipt) { Storage::disk('public')->delete($user->admission_receipt); $user->admission_receipt = null; }
        $user->save();

        return redirect()->route('admin.admissions.index')->with('success', 'Pembayaran ditolak. Mahasiswa harus mengunggah ulang bukti transfer.');
    }
}
