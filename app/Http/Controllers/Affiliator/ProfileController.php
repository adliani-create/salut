<?php

namespace App\Http\Controllers\Affiliator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('affiliator.profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'bank_account_owner' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Update basic info
        $user->name = $request->name;
        $user->whatsapp = $request->whatsapp;
        
        // Update bank info
        $user->bank_name = $request->bank_name;
        $user->bank_account = $request->bank_account;
        $user->bank_account_owner = $request->bank_account_owner;
        
        $user->save();
        $user->refresh();

        return redirect()->route('affiliator.profile.edit')->with('status', 'profile-updated');
    }
}
