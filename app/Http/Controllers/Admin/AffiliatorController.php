<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AffiliatorController extends Controller
{
    /**
     * Display a listing of Affiliators.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $affiliators = User::whereHas('role', function ($q) {
                $q->where('name', 'affiliator');
            })
            ->with(['referrer']) // Load upline (Mitra)
            ->withCount(['referrals as students_count' => function ($query) {
                $query->whereHas('role', function ($q) {
                    $q->where('name', 'mahasiswa');
                });
            }])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('referral_code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('admin.affiliators.index', compact('affiliators', 'search'));
    }

    /**
     * Display Affiliator details and list of recruited students.
     */
    public function show(User $affiliator)
    {
        // Ensure user is an affiliator
        if (!$affiliator->isAffiliator()) {
            abort(404);
        }

        $affiliator->load(['referrer', 'mitraProfile']); // Load upline

        // Students recruited by this affiliator
        $students = User::where('referred_by', $affiliator->id)
            ->whereHas('role', function ($q) {
                $q->where('name', 'mahasiswa');
            })
            ->with('registration') // Assuming Registration model holds 'fokus_karir' and 'jalur_pendaftaran'
            ->latest()
            ->paginate(20);

        return view('admin.affiliators.show', compact('affiliator', 'students'));
    }

    /**
     * Show form to edit affiliator status
     */
    public function edit(User $affiliator)
    {
        if (!$affiliator->isAffiliator()) {
            abort(404);
        }

        return view('admin.affiliators.edit', compact('affiliator'));
    }

    /**
     * Update affiliator details/status
     */
    public function update(Request $request, User $affiliator)
    {
        if (!$affiliator->isAffiliator()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $affiliator->id,
            'whatsapp' => 'nullable|string|max:20',
            'status' => 'required|in:active,suspended',
        ]);

        $affiliator->update($validated);

        return redirect()->route('admin.affiliators.index')->with('success', 'Data Affiliator berhasil diperbarui.');
    }

    /**
     * Suspend/Delete logic (Soft disable is safer than delete)
     */
    public function destroy(User $affiliator)
    {
        if (!$affiliator->isAffiliator()) {
            abort(404);
        }

        $affiliator->update(['status' => 'suspended']);

        return back()->with('success', 'Akun affiliator berhasil dibekukan.');
    }
}
