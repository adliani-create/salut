<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Not used, users register themselves or via a different flow
        abort(404);
    }

    public function store(Request $request)
    {
        // Not used
        abort(404);
    }

    public function show(\App\Models\User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(\App\Models\User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,mahasiswa,yayasan,staff',
        ]);

        $user->update([
            'role' => $validated['role']
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }

    public function destroy(\App\Models\User $user)
    {
        // Prevent deleting self
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
