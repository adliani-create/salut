<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesters = \App\Models\Semester::all();
        return view('admin.semester.index', compact('semesters'));
    }

    public function create()
    {
        return view('admin.semester.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // If setting to active, deactivate others (optional logic, but good for semesters)
        if ($request->has('is_active') && $request->is_active) {
            \App\Models\Semester::where('is_active', true)->update(['is_active' => false]);
        }
        
        $validated['is_active'] = $request->has('is_active');

        \App\Models\Semester::create($validated);

        return redirect()->route('admin.semester.index')->with('success', 'Semester created successfully.');
    }

    public function edit(\App\Models\Semester $semester)
    {
        return view('admin.semester.edit', compact('semester'));
    }

    public function update(Request $request, \App\Models\Semester $semester)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->has('is_active') && $request->is_active) {
            \App\Models\Semester::where('id', '!=', $semester->id)->where('is_active', true)->update(['is_active' => false]);
        }
        
        $validated['is_active'] = $request->has('is_active');

        $semester->update($validated);

        return redirect()->route('admin.semester.index')->with('success', 'Semester updated successfully.');
    }

    public function destroy(\App\Models\Semester $semester)
    {
        $semester->delete();
        return redirect()->route('admin.semester.index')->with('success', 'Semester deleted successfully.');
    }
}
