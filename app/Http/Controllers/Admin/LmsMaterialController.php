<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LmsMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = \App\Models\LmsMaterial::all();
        return view('admin.lms_materials.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.lms_materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'type' => 'required|in:video,ebook',
            'file' => 'required|file|mimes:pdf,mp4,mkv,avi,doc,docx|max:20480', // limit 20MB
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('lms_materials', 'public');
            $validated['file_path'] = $path;
        }

        \App\Models\LmsMaterial::create($validated);
        return redirect()->route('admin.lms-materials.index')->with('success', 'Material uploaded successfully.');
    }

    public function edit(\App\Models\LmsMaterial $lmsMaterial)
    {
        return view('admin.lms_materials.edit', compact('lmsMaterial'));
    }

    public function update(Request $request, \App\Models\LmsMaterial $lmsMaterial)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'type' => 'required|in:video,ebook',
            'file' => 'nullable|file|mimes:pdf,mp4,mkv,avi,doc,docx|max:20480',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file? Optionally.
            $path = $request->file('file')->store('lms_materials', 'public');
            $validated['file_path'] = $path;
        }

        $lmsMaterial->update($validated);
        return redirect()->route('admin.lms-materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(\App\Models\LmsMaterial $lmsMaterial)
    {
        // Delete file?
        // Storage::disk('public')->delete($lmsMaterial->file_path);
        
        $lmsMaterial->delete();
        return redirect()->route('admin.lms-materials.index')->with('success', 'Material deleted successfully.');
    }
}
