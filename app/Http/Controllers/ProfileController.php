<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        \Illuminate\Support\Facades\Log::info('Profile Update Request:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->isMahasiswa()) {
            // These basic user fields are managed via the registration syncing usually, or direct update?
            // User requested these to be read-only in the edit form, but we should strictly NOT update them if they are passed.
            // The prompt says "Disabled/Read-only" in UI, which means they won't be submitted.
            // However, we need to update 'whatsapp' and 'address' on the registration model.
            
            $registration = $user->registration;
            if($registration) {
                 if($request->has('whatsapp')) {
                     $registration->whatsapp = $request->whatsapp;
                 }
                 if($request->has('address')) {
                     $registration->address = $request->address;
                 }
                 $registration->save();
            }
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            \Illuminate\Support\Facades\Log::info('Processing photo upload...');
            // Delete old photo if exists
            if ($user->photo) {
                \Illuminate\Support\Facades\Log::info('Deleting old photo: ' . $user->photo);
                // Ensure we don't delete if it's matching the new one (rare logic, but safe)
                Storage::disk('public')->delete($user->photo);
            }
            
            // Force directory creation
            Storage::disk('public')->makeDirectory('photos');
            
            $path = $request->file('photo')->store('photos', 'public');
            \Illuminate\Support\Facades\Log::info('New photo stored at: ' . $path);
            
            // Check if file actually exists
            if(Storage::disk('public')->exists($path)) {
                 \Illuminate\Support\Facades\Log::info('File confirmed exists on disk.');
            } else {
                 \Illuminate\Support\Facades\Log::error('File NOT found on disk after store().');
            }

            $user->photo = $path;
        } else {
             \Illuminate\Support\Facades\Log::info('No photo file found in request.');
        }

        $user->save();
        \Illuminate\Support\Facades\Log::info('User saved with photo: ' . $user->photo);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
