<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = \App\Models\Prodi::with('fakultas')->get();
        return view('admin.prodi.index', compact('prodis'));
    }

    public function create()
    {
        $fakultas = \App\Models\Fakultas::all();
        return view('admin.prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:prodis',
            'jenjang' => 'required|string|max:10',
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);

        \App\Models\Prodi::create($validated);

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi created successfully.');
    }

    public function edit(\App\Models\Prodi $prodi)
    {
        $fakultas = \App\Models\Fakultas::all();
        return view('admin.prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, \App\Models\Prodi $prodi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:prodis,kode,' . $prodi->id,
            'jenjang' => 'required|string|max:10',
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);

        $prodi->update($validated);

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi updated successfully.');
    }

    public function destroy(\App\Models\Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->route('admin.prodi.index')->with('success', 'Prodi deleted successfully.');
    }
}
