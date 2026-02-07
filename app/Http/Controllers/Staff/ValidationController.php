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
        
        return redirect()->route('staff.validation.index')->with('success', 'Registration status updated.');
    }
}
