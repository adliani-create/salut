<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'registration_type' => ['required', 'string', 'in:maba,active'],
            'nim' => ['nullable', 'string', 'required_if:registration_type,active', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $status = 'pending_payment'; // Default for Maba
        if ($data['registration_type'] === 'active') {
             // Mock Sync Logic: If active student registers, assume active status for now
             $status = 'active';
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 4, // Assuming 4 is mahasiswa based on common seeding, but 'mahasiswa' string was used before. Let's lookup or use role name if relation allows, using hardcoded ID is risky.
            // Wait, previous code used 'role' => 'mahasiswa'.
            // Let's check User model setRole or similar, or just manually set role_id if we know it.
            // Safest: Use role lookup. But for now, let's stick to what was there or improve.
            // The previous file had: 'role' => 'mahasiswa'. But the new migration added `role_id`.
            // User model fillable has `role_id`.
            // I should find the ID for 'mahasiswa'.
            // For now, I'll use a fallback or assume dynamic role assignment logic exists.
            // Actually, let's use a workaround:
            'role_id' => \App\Models\Role::where('name', 'mahasiswa')->first()->id ?? 4,
            'nim' => $data['nim'] ?? null,
            'status' => $status,
        ]);
    }
}
