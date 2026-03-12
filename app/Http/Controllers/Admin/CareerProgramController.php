<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerProgram;
use Illuminate\Http\Request;

class CareerProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = CareerProgram::all();
        return view('admin.career_programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.career_programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:career_programs',
            'description' => 'nullable|string',
        ]);

        CareerProgram::create($request->except('_token'));

        return redirect()->route('admin.career-programs.index')
            ->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CareerProgram $careerProgram)
    {
        return view('admin.career_programs.edit', compact('careerProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CareerProgram $careerProgram)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:career_programs,name,' . $careerProgram->id,
            'description' => 'nullable|string',
        ]);

        $careerProgram->update($request->all());

        return redirect()->route('admin.career-programs.index')
            ->with('success', 'Program berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CareerProgram $careerProgram)
    {
        $careerProgram->delete();

        return redirect()->route('admin.career-programs.index')
            ->with('success', 'Program berhasil dihapus.');
    }
}
