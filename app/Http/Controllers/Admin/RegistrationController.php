<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');
        // Acts as an Inbox: Only show pending registrations
        $registrations = Registration::with('user')
            ->where('status', 'pending')
            ->whereHas('user', function ($q) {
                $q->whereHas('role', function ($r) {
                    $r->where('name', 'mahasiswa');
                });
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.registrations.index', compact('registrations', 'search'));
    }

    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:valid,invalid',
            'admin_notes' => 'nullable|string'
        ]);

        $registration->update($validated);

        return redirect()->route('admin.registrations.index')->with('success', 'Registration status updated successfully.');
    }

    public function approve(Request $request, Registration $registration)
    {
        $request->validate([
            'nim' => 'required|string|unique:users,nim,' . $registration->user_id, // Unique but ignore self if updating? actually user doesn't have nim yet so unique simple is fine.
            'faculty' => 'required|string',
            'major' => 'required|string',
            'semester' => 'required|integer|min:1',
        ]);

        // Update User Data
        $user = $registration->user;
        $user->update([
            'nim' => $request->nim,
            'faculty' => $request->faculty,
            'major' => $request->major,
            'semester' => $request->semester,
            'status' => 'active', // Set user as active student
        ]);

        // --- POINT DISTRIBUTION LOGIC ---
        // 1. Check if student has a referrer (Direct Recruiter: Affiliator or Mitra)
        if ($user->referred_by) {
            $directReferrer = \App\Models\User::find($user->referred_by);

            if ($directReferrer && $directReferrer->status === 'active') {
                // Determine the role for description
                $roleName = $directReferrer->hasRole('mitra') ? 'Mitra' : 'Affiliator';

                // Give 10 points to the direct recruiter
                \App\Models\PointLedger::create([
                    'user_id' => $directReferrer->id,
                    'type' => 'credit',
                    'amount' => 10,
                    'source_id' => $user->id,
                    'description' => "Komisi Referensi Mahasiswa Baru ($roleName): " . $user->name,
                ]);

                // 2. Check if the Direct Recruiter has a referrer (Bonus Supervisi for Mitra)
                // This only happens if the direct recruiter is an Affiliator, and their parent is a Mitra
                if ($directReferrer->referred_by && $directReferrer->hasRole('affiliator')) {
                    $mitra = \App\Models\User::find($directReferrer->referred_by);

                    if ($mitra && $mitra->hasRole('mitra') && $mitra->status === 'active') {
                        \App\Models\PointLedger::create([
                            'user_id' => $mitra->id,
                            'type' => 'credit',
                            'amount' => 2,
                            'source_id' => $user->id,
                            'description' => "Bonus Supervisi Jaringan Mahasiswa dari Tim ({$directReferrer->name}): " . $user->name,
                        ]);
                    }
                }
            }
        }
        // --- END POINT DISTRIBUTION LOGIC ---

        // Update Registration Status
        $registration->update([
            'status' => 'valid',
            'admin_notes' => 'Approved and Active. NIM: ' . $request->nim,
        ]);

        return redirect()->route('admin.registrations.index')->with('success', 'Mahasiswa berhasil disetujui dan diaktifkan.');
    }
}
