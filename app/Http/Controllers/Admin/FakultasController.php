<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fakultas = \App\Models\Fakultas::all();
        return view('admin.fakultas.index', compact('fakultas'));
    }

    public function create()
    {
        return view('admin.fakultas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:fakultas',
            'description' => 'nullable|string',
        ]);

        \App\Models\Fakultas::create($validated);

        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas created successfully.');
    }

    public function edit(\App\Models\Fakultas $fakultas)
    {
        return view('admin.fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, \App\Models\Fakultas $fakultas)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:fakultas,kode,' . $fakultas->id,
            'description' => 'nullable|string',
        ]);

        $fakultas->update($validated);

        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas updated successfully.');
    }

    public function destroy(\App\Models\Fakultas $fakultas)
    {
        $fakultas->delete();
        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas deleted successfully.');
    }
}
