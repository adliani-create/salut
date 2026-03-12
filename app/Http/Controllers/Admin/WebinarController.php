<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class webinarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $webinars = \App\Models\webinar::orderBy('date', 'desc')->get();
        return view('admin.webinars.index', compact('webinars'));
    }

    public function create()
    {
        return view('admin.webinars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string',
            'speaker' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'link' => 'nullable|url',
        ]);

        \App\Models\webinar::create($validated);
        return redirect()->route('admin.webinars.index')->with('success', 'webinar scheduled successfully.');
    }

    public function edit(\App\Models\webinar $webinar)
    {
        return view('admin.webinars.edit', compact('webinar'));
    }

    public function update(Request $request, \App\Models\webinar $webinar)
    {
        $validated = $request->validate([
            'topic' => 'required|string',
            'speaker' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'link' => 'nullable|url',
        ]);

        $webinar->update($validated);
        return redirect()->route('admin.webinars.index')->with('success', 'webinar updated successfully.');
    }

    public function destroy(\App\Models\webinar $webinar)
    {
        $webinar->delete();
        return redirect()->route('admin.webinars.index')->with('success', 'webinar deleted successfully.');
    }
}
