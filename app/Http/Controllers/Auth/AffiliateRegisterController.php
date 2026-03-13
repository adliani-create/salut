<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class AffiliateRegisterController extends Controller
{
    /**
     * Show the affiliate registration form
     */
    public function showRegistrationForm(Request $request)
    {
        // Capture referral code if present
        $ref = $request->query('ref');
        
        $mitra = null;
        if ($ref) {
            $mitra = User::where('referral_code', $ref)
                ->whereHas('role', function($q) {
                    $q->whereIn('name', ['mitra', 'affiliator']);
                })->first();
        }

        return view('auth.register_affiliate', compact('mitra', 'ref'));
    }

    /**
     * Handle affiliate registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'numeric', 'digits:9', 'unique:users,nim'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'bank_name' => ['required', 'string', 'max:100'],
            'bank_account' => ['required', 'string', 'max:100'],
            'bank_account_owner' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ref' => ['required', 'string', 'exists:users,referral_code'],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.digits' => 'NIM harus tepat 9 digit angka.',
            'nim.unique' => 'NIM ini sudah terdaftar sebelumnya.',
            'nim.numeric' => 'NIM hanya boleh berisi angka.',
            'ref.required' => 'Kode Referensi Rekrutmen wajib diisi.',
            'ref.exists' => 'Kode Referensi Rekrutmen tidak valid atau tidak ditemukan.',
            'bank_name.required' => 'Nama Bank wajib diisi.',
            'bank_account.required' => 'No. Rekening wajib diisi.',
            'bank_account_owner.required' => 'Atas Nama wajib diisi.',
        ]);

        // Find referring Upline (Mitra or Affiliator)
        $uplineId = null;
        if ($request->ref) {
            $upline = User::where('referral_code', $request->ref)
                ->whereHas('role', function($q) {
                    $q->whereIn('name', ['mitra', 'affiliator']);
                })->first();
                
            if ($upline) {
                $uplineId = $upline->id;
            } else {
                return back()->withInput()->withErrors(['ref' => 'Kode referensi harus berasal dari Mitra atau Affiliator resmi.']);
            }
        } else {
            return back()->withInput()->withErrors(['ref' => 'Pendaftaran Affiliator wajib menggunakan tautan undangan/referral.']);
        }

        $affiliatorRole = Role::firstOrCreate(
            ['name' => 'affiliator'],
            ['label' => 'Affiliator', 'redirect_to' => '/affiliator/dashboard']
        );

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role_id' => $affiliatorRole->id,
            'referred_by' => $uplineId, // Penerapan Aturan 1: ID Upline masuk ke parent
            'is_affiliator' => true,
        ]);

        // Save bank account info (Assuming we will create a profile table or repurpose mitra_profiles, 
        // for now let's just create the MitraProfile record or handle it later. Wait, Affiliators aren't Mitras.
        // I will add `bank_account` to the `users` table via migration directly).

        // Penerapan Aturan 4: Auto-generate new referral code for this Affiliate
        $user->referral_code = $this->generateReferralCode($user);
        $user->bank_name = $request->bank_name;
        $user->bank_account = $request->bank_account;
        $user->bank_account_owner = $request->bank_account_owner;
        $user->save();

        event(new Registered($user));

        // Create Pending Registration for Staff Validation
        \App\Models\Registration::create([
            'user_id' => $user->id,
            'registration_number' => 'REG-' . date('Ymd') . '-' . rand(1000, 9999),
            'status' => 'pending', 
            // Fake other fields if required or make them nullable in DB
        ]);

        Auth::login($user);

        return redirect()->route('affiliator.dashboard')->with('success', 'Pendaftaran Affiliator berhasil. Selamat bergabung!');
    }
    
    /**
     * Helper to generate unique referral code
     */
    private function generateReferralCode($user)
    {
        // Format: AFF-SALUT-[3 letters of name]-[Random 4 digits]
        $namePart = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $user->name), 0, 3));
        $namePart = str_pad($namePart, 3, 'X'); 

        do {
            $code = 'AFF-SALUT-' . $namePart . '-' . rand(1000, 9999);
            $exists = User::where('referral_code', $code)->exists();
        } while ($exists);

        return $code;
    }
}
