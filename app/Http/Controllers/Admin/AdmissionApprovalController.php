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

        // 1. Activate Student
        $user->status = 'active';
        $user->save();

        // 2. Grant 50 Poin (Rp 50.000) to Referrer if exists
        $referrerId = $user->referred_by;
        if ($referrerId) {
            $referrer = User::find($referrerId);
            if ($referrer) {
                PointLedger::create([
                    'user_id' => $referrerId,
                    'amount' => 50000,
                    'type' => 'credit',
                    'description' => 'Komisi pendaftaran valid mahasiswa: ' . $user->name,
                ]);

                // Do not increment missing total_points column
            }
        }

        return redirect()->route('admin.admissions.index')->with('success', 'Pembayaran Admisi disetujui. Mahasiswa sekarang berstatus Aktif.');
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
