<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = \App\Models\Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|alpha_dash',
            'label' => 'required|string',
            'redirect_to' => 'required|string',
        ]);

        \App\Models\Role::create($validated);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function show(\App\Models\Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function edit(\App\Models\Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, \App\Models\Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|alpha_dash|unique:roles,name,' . $role->id,
            'label' => 'required|string',
            'redirect_to' => 'required|string',
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(\App\Models\Role $role)
    {
        // Optional: Prevent deleting default roles if needed
        // if (in_array($role->name, ['admin', 'mahasiswa'])) {
        //    return back()->with('error', 'Cannot delete system roles.');
        // }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
