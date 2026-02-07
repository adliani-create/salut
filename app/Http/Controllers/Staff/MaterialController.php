<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = \App\Models\CourseMaterial::all();
        return view('staff.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('staff.materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'program' => 'nullable|string',
            'semester' => 'nullable|string',
            'file' => 'required|file|max:20480',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
        }

        \App\Models\CourseMaterial::create($validated);
        return redirect()->route('staff.materials.index')->with('success', 'Material distributed successfully.');
    }

    public function destroy(\App\Models\CourseMaterial $material)
    {
        $material->delete();
        return redirect()->route('staff.materials.index')->with('success', 'Material deleted.');
    }
}
