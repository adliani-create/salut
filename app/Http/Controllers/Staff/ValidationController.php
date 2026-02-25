<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index()
    {
        $registrations = \App\Models\Registration::with('user')->orderBy('created_at', 'desc')->get();
        return view('staff.validation.index', compact('registrations'));
    }

    public function show(\App\Models\Registration $registration)
    {
        return view('staff.validation.show', compact('registration'));
    }

    public function update(Request $request, \App\Models\Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:valid,invalid',
            'admin_notes' => 'nullable|string'
        ]);

        $registration->update($validated);

        // If newly validated, mark User as active and give points to Affiliator/Mitra
        if ($validated['status'] === 'valid' && $registration->user->status !== 'active') {
            $registration->user->update(['status' => 'active']);

            $referrerId = $registration->user->referred_by;
            if ($referrerId) {
                $referrer = \App\Models\User::find($referrerId);
                if ($referrer) {
                    \App\Models\PointLedger::create([
                        'user_id' => $referrerId,
                        'amount' => 10,
                        'type' => 'credit',
                        'description' => 'Komisi pendaftaran valid mahasiswa: ' . $registration->user->name
                    ]);

                    // Update total points cache if exists
                    $referrer->increment('total_points', 10);
                }
            }
        }
        
        return redirect()->route('staff.validation.index')->with('success', 'Registration status updated and User activated (if valid).');
    }
}
