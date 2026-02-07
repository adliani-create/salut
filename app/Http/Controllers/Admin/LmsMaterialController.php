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
        $programs = \App\Models\CareerProgram::all();
        return view('admin.lms_materials.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'title' => 'required|string',
            'type' => 'required|in:video,ebook,assignment',
            'file' => 'required|file|mimes:pdf,mp4,mkv,avi,doc,docx|max:1048576', // limit 1GB
            'thumbnail' => 'nullable|image|max:2048', // 2MB max for thumbnail
            'duration' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('lms_materials', 'public');
            $validated['file_path'] = $path;
        }

        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('lms_thumbnails', 'public');
            $validated['thumbnail'] = $thumbPath;
        }

        $material = \App\Models\LmsMaterial::create($validated);
        
        // Sync programs if provided
        if ($request->has('career_program_ids')) {
            $material->careerPrograms()->sync($request->career_program_ids);
        }

        return redirect()->route('admin.lms-materials.index')->with('success', 'Material uploaded successfully.');
    }

    public function edit(\App\Models\LmsMaterial $lmsMaterial)
    {
        $programs = \App\Models\CareerProgram::all();
        $lmsMaterial->load('careerPrograms');
        return view('admin.lms_materials.edit', compact('lmsMaterial', 'programs'));
    }

    public function update(Request $request, \App\Models\LmsMaterial $lmsMaterial)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'title' => 'required|string',
            'type' => 'required|in:video,ebook,assignment',
            'file' => 'nullable|file|mimes:pdf,mp4,mkv,avi,doc,docx|max:1048576',
            'thumbnail' => 'nullable|image|max:2048',
            'duration' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file? Optionally.
            $path = $request->file('file')->store('lms_materials', 'public');
            $validated['file_path'] = $path;
        }

        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('lms_thumbnails', 'public');
            $validated['thumbnail'] = $thumbPath;
        }

        $lmsMaterial->update($validated);
        
        // Sync programs if provided
        if ($request->has('career_program_ids')) {
            $lmsMaterial->careerPrograms()->sync($request->career_program_ids);
        }

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
