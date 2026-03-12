<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\MitraProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class MitraRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register_mitra');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:100',
            'bank_account_name' => 'nullable|string|max:255',
        ]);

        $mitraRole = Role::firstOrCreate(
            ['name' => 'mitra'],
            ['label' => 'Mitra SALUT', 'redirect_to' => '/mitra/dashboard']
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role_id' => $mitraRole->id,
            'status' => 'pending',
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

        event(new Registered($user));

        return redirect()->route('kemitraan.landing')->with('success', 'Pendaftaran Mitra berhasil dikirim! Tim kami akan meninjau pendaftaran Anda segera. Kami akan menghubungi Anda melalui WhatsApp atau Email jika pengajuan disetujui.');
    }
}
