<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Registration;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentRegisterController extends Controller
{
    /**
     * Show Landing Page (Split Option)
     */
    public function showLanding(Request $request)
    {
        if ($request->has('ref')) {
            session(['referral_code' => $request->ref]);
        }
        return view('auth.register-landing');
    }

    /**
     * Show Step 1: Account Creation (Mahasiswa Baru)
     */
    public function showStep1(Request $request)
    {
        if ($request->has('ref')) {
            session(['referral_code' => $request->ref]);
        }
        return view('auth.register');
    }

    /**
     * Show Full Form for Existing Student
     */
    public function showExistingForm(Request $request)
    {
        if ($request->has('ref')) {
            session(['referral_code' => $request->ref]);
        }
        $programs = \App\Models\CareerProgram::all();
        $fakultas = Fakultas::all();
        $prodis = Prodi::all();
        return view('auth.register-existing-full', compact('programs', 'fakultas', 'prodis'));
    }

    /**
     * Store Full Form for Existing Student
     */
    public function storeExistingForm(Request $request)
    {
        $request->validate([
            // Identity
            'nim' => ['required', 'numeric', 'digits:9', 'unique:users,nim'], // Ensure unique and strict 9 digits
            'name' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'integer', 'digits:4'],
            
            // Account
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            
            // Update Data
            'whatsapp' => ['required', 'numeric'],
            'jenjang' => ['required', 'in:S1,S2'],
            'fakultas_id' => ['required', 'exists:fakultas,id'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'fokus_karir' => ['required', 'string'],
        ]);

        // Lookup Names
        $fakultasName = Fakultas::find($request->fakultas_id)->nama;
        $prodiName = Prodi::find($request->prodi_id)->nama;

        // Check for Referral
        $referredBy = null;
        if (session()->has('referral_code')) {
            $referrer = User::where('referral_code', session('referral_code'))->first();
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'mahasiswa')->first()->id ?? 4,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'status' => 'active', // Express: Directly active
            'referred_by' => $referredBy,
        ]);

        // Create Registration Data
        Registration::create([
            'user_id' => $user->id,
            'whatsapp' => $request->whatsapp,
            'fokus_karir' => $request->fokus_karir,
            'jenjang' => $request->jenjang,
            'fakultas' => $fakultasName,
            'prodi' => $prodiName,
            'status' => 'valid', // Express: Directly valid
            'jalur_pendaftaran' => 'Reguler', // Default
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Akun Anda sedang dalam verifikasi admin.');
    }

    /**
     * Process Step 1
     */
    public function storeStep1(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Get Mahasiswa Role
        $role = Role::where('name', 'mahasiswa')->first();
        if (!$role) {
            return back()->with('error', 'Role mahasiswa not found. Please contact admin.');
        }

        // Check for Referral
        $referredBy = null;
        if (session()->has('referral_code')) {
            $referrer = User::where('referral_code', session('referral_code'))->first();
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'referred_by' => $referredBy,
        ]);

        // Create Draft Registration
        Registration::create([
            'user_id' => $user->id,
            'status' => 'draft',
            'files' => [],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('register.step2');
    }

    /**
     * Show Step 2: Academic Data
     */
    public function showStep2()
    {
        $user = Auth::user();
        if (!$user->registration) {
             // If no registration exists for some reason, create one
             Registration::create([
                'user_id' => $user->id,
                'status' => 'draft',
            ]);
        }
        
        // If already completed, redirect to dashboard
        if ($user->registration && $user->registration->status != 'draft') {
            return redirect()->route('home');
        }

        $fakultas = Fakultas::all();
        $prodis = Prodi::all();
        return view('auth.register-step2', compact('fakultas', 'prodis'));
    }

    /**
     * Process Step 2
     */
    public function storeStep2(Request $request)
    {
        $request->validate([
            'whatsapp' => ['required', 'numeric'],
            'jenjang' => ['required', 'in:S1,S2'],
            'fakultas_id' => ['required', 'exists:fakultas,id'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'jalur_pendaftaran' => ['required', 'in:Reguler,RPL'],
        ]);

        $registration = Auth::user()->registration;

        if (!$registration) {
             // Create if missing
             $registration = Registration::create([
                'user_id' => Auth::id(),
                'status' => 'draft',
                'files' => [],
            ]);
        }
        
        // Lookup Names
        $fakultasName = Fakultas::find($request->fakultas_id)->nama;
        $prodiName = Prodi::find($request->prodi_id)->nama;

        $registration->update([
            'whatsapp' => $request->whatsapp,
            'jenjang' => $request->jenjang,
            'fakultas' => $fakultasName,
            'prodi' => $prodiName,
            'jalur_pendaftaran' => $request->jalur_pendaftaran,
            'status' => 'draft', // Keep as draft until step 3
        ]);

        return redirect()->route('register.step3');
    }

    /**
     * Show Step 3: Career Focus
     */
    public function showStep3()
    {
         $user = Auth::user();
         if (!$user->registration || $user->registration->status != 'draft') {
             // If completed or no registration, redirect appropriately
             if ($user->registration && $user->registration->status != 'draft') {
                 return redirect()->route('home');
             }
             return redirect()->route('register.step2');
         }

        $programs = \App\Models\CareerProgram::all();
        return view('auth.register-step3', compact('programs'));
    }

    /**
     * Process Step 3
     */
    public function storeStep3(Request $request)
    {
        $request->validate([
            'fokus_karir' => ['required', 'string', 'exists:career_programs,name'],
        ]);

        $registration = Auth::user()->registration;

        $registration->update([
            'fokus_karir' => $request->fokus_karir,
            'status' => 'pending', // Finalize registration
        ]);

        // Auto-Generate Tagihan Layanan SALUT
        \App\Models\Billing::create([
            'user_id' => Auth::id(),
            'billing_code' => 'INV-' . date('Ym') . '-' . rand(1000, 9999),
            'category' => 'Layanan SALUT',
            'amount' => 150000, // Hardcoded default based on prompt
            'semester' => 1,
            'due_date' => now()->addDays(30),
            'status' => 'unpaid',
            'description' => 'Tagihan Aktivasi Layanan SALUT Mahasiswa Baru',
        ]);

        return redirect()->route('home')->with('status', 'Registrasi berhasil! Silakan selesaikan pembayaran aktivasi layanan Anda.');
    }
}
