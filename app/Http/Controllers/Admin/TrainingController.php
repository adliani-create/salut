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
        $programs = [
            'Kuliah plus Magang Kerja',
            'Kuliah Plus Skill Academy',
            'Kuliah plus Affiliator & Creator',
            'Kuliah Plus Wirausaha',
        ];
        return view('admin.trainings.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'program' => 'required|string',
            'instructor' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);

        \App\Models\Training::create($validated);
        return redirect()->route('admin.trainings.index')->with('success', 'Training scheduled successfully.');
    }

    public function edit(\App\Models\Training $training)
    {
        $programs = [
            'Kuliah plus Magang Kerja',
            'Kuliah Plus Skill Academy',
            'Kuliah plus Affiliator & Creator',
            'Kuliah Plus Wirausaha',
        ];
        return view('admin.trainings.edit', compact('training', 'programs'));
    }

    public function update(Request $request, \App\Models\Training $training)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'program' => 'required|string',
            'instructor' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $training->update($validated);
        return redirect()->route('admin.trainings.index')->with('success', 'Training updated successfully.');
    }

    public function destroy(\App\Models\Training $training)
    {
        $training->delete();
        return redirect()->route('admin.trainings.index')->with('success', 'Training deleted successfully.');
    }
}
