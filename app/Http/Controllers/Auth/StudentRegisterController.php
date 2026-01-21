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
    public function showLanding()
    {
        return view('auth.register-landing');
    }

    /**
     * Show Step 1: Account Creation (Mahasiswa Baru)
     */
    public function showStep1()
    {
        return view('auth.register');
    }

    /**
     * Show Full Form for Existing Student
     */
    public function showExistingForm()
    {
        return view('auth.register-existing-full');
    }

    /**
     * Store Full Form for Existing Student
     */
    public function storeExistingForm(Request $request)
    {
        $request->validate([
            // Identity
            'nim' => ['required', 'string', 'unique:users,nim'], // Ensure unique or handle claim logic later
            'name' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'integer', 'digits:4'],
            
            // Account
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            
            // Update Data
            'whatsapp' => ['required', 'numeric'],
            'fokus_karir' => ['required', 'string'],
        ]);

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'mahasiswa')->first()->id ?? 4,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'status' => 'pending', // Waiting verification
        ]);

        // Create Registration Data
        Registration::create([
            'user_id' => $user->id,
            'whatsapp' => $request->whatsapp,
            'fokus_karir' => $request->fokus_karir,
            'status' => 'pending',
            // Defaulting others or leaving null as they are "Existing" so might not need filling
            'jenjang' => 'S1', // Default or ask? Prompt didn't specify.
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
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
        return view('auth.register-step2', compact('fakultas'));
    }

    /**
     * Process Step 2
     */
    public function storeStep2(Request $request)
    {
        $request->validate([
            'whatsapp' => ['required', 'numeric'],
            'jenjang' => ['required', 'in:S1,S2'],
            'fakultas' => ['required', 'string', 'max:255'],
            'prodi' => ['required', 'string', 'max:255'],
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
        
        $registration->update([
            'whatsapp' => $request->whatsapp,
            'jenjang' => $request->jenjang,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
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

        return view('auth.register-step3');
    }

    /**
     * Process Step 3
     */
    public function storeStep3(Request $request)
    {
        $request->validate([
            'fokus_karir' => ['required', 'string', 'in:Kuliah Plus Magang Kerja,Kuliah Plus Skill Academy,Kuliah Plus Affiliator/Creator,Kuliah Plus Wirausaha'],
        ]);

        $registration = Auth::user()->registration;

        $registration->update([
            'fokus_karir' => $request->fokus_karir,
            'status' => 'pending', // Finalize registration
        ]);

        return redirect()->route('home')->with('status', 'Registrasi berhasil! Data Anda sedang diverifikasi admin.');
    }
}
