<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        // Acts as an Inbox: Only show pending registrations
        $registrations = Registration::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.registrations.index', compact('registrations'));
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

        // Update Registration Status
        $registration->update([
            'status' => 'valid',
            'admin_notes' => 'Approved and Active. NIM: ' . $request->nim,
        ]);

        return redirect()->route('admin.registrations.index')->with('success', 'Mahasiswa berhasil disetujui dan diaktifkan.');
    }
}
