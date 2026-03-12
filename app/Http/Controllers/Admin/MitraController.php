<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\MitraProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = User::whereHas('role', function ($q) {
            $q->where('name', 'mitra');
        })->with('mitraProfile')->paginate(10);

        return view('admin.mitras.index', compact('mitras'));
    }

    public function create()
    {
        return view('admin.mitras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'company_name' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:100',
            'bank_account_name' => 'nullable|string|max:255',
        ]);

        $mitraRole = Role::where('name', 'mitra')->firstOrFail();

        // Generate unique referral code
        $referralCode = 'MTR-' . strtoupper(Str::random(6));
        while (User::where('referral_code', $referralCode)->exists()) {
            $referralCode = 'MTR-' . strtoupper(Str::random(6));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role_id' => $mitraRole->id,
            'referral_code' => $referralCode,
        ]);

        MitraProfile::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'pic_name' => $request->pic_name,
            'address' => $request->address,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
        ]);

        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil didaftarkan. Kode Referral: ' . $referralCode);
    }

    public function show(User $user)
    {
        // Pastikan $user adalah mitra
        if (!$user->isMitra()) {
            abort(404);
        }

        // Load profile and network logic going here later
        $user->load(['mitraProfile', 'referrals']);
        return view('admin.mitras.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!$user->isMitra()) {
            abort(404);
        }
        
        $user->load('mitraProfile');
        return view('admin.mitras.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!$user->isMitra()) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'whatsapp' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'company_name' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:100',
            'bank_account_name' => 'nullable|string|max:255',
            'status' => 'required|in:active,suspended',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        MitraProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'company_name' => $request->company_name,
                'pic_name' => $request->pic_name,
                'address' => $request->address,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
            ]
        );

        return redirect()->route('admin.mitras.index')->with('success', 'Data Mitra berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!$user->isMitra()) {
            abort(404);
        }

        // Alternatively to deleting, we could just suspend.
        $user->update(['status' => 'suspended']);
        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil disuspend.');
    }
}
