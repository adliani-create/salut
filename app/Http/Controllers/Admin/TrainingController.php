<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainings = \App\Models\Training::orderBy('date', 'asc')->get();
        return view('admin.trainings.index', compact('trainings'));
    }

    public function create()
    {
        $programs = \App\Models\CareerProgram::all();
        return view('admin.trainings.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'career_program_ids' => 'required|array', // Allow multiple programs
            'career_program_ids.*' => 'exists:career_programs,id',
            'instructor' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Create training - for 'program' column, we can store a string representation or the first selected program
        // This maintains backward compatibility if 'program' column is still used elsewhere
        $programs = \App\Models\CareerProgram::whereIn('id', $request->career_program_ids)->pluck('name')->toArray();
        $validated['program'] = implode(', ', $programs);

        $training = \App\Models\Training::create($validated);
        
        // Sync relationships
        $training->careerPrograms()->sync($request->career_program_ids);

        return redirect()->route('admin.trainings.index')->with('success', 'Training scheduled successfully.');
    }

    public function edit(\App\Models\Training $training)
    {
        $programs = \App\Models\CareerProgram::all();
        $training->load('careerPrograms'); // Load existing relations
        return view('admin.trainings.edit', compact('training', 'programs'));
    }

    public function update(Request $request, \App\Models\Training $training)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'career_program_ids' => 'required|array',
            'career_program_ids.*' => 'exists:career_programs,id',
            'instructor' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $programs = \App\Models\CareerProgram::whereIn('id', $request->career_program_ids)->pluck('name')->toArray();
        $validated['program'] = implode(', ', $programs);

        $training->update($validated);
        $training->careerPrograms()->sync($request->career_program_ids);
        
        return redirect()->route('admin.trainings.index')->with('success', 'Training updated successfully.');
    }

    public function destroy(\App\Models\Training $training)
    {
        $training->delete();
        return redirect()->route('admin.trainings.index')->with('success', 'Training deleted successfully.');
    }
}
