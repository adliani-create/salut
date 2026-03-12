<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSchedule;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;

class AcademicScheduleController extends Controller
{
    public function index()
    {
        $schedules = AcademicSchedule::with(['prodi', 'user'])->orderBy('date', 'desc')->orderBy('time', 'asc')->get();
        return view('admin.academic_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $programs = Prodi::orderBy('nama')->get();
        // Fetch only students (mahasiswa)
        $students = User::whereHas('role', function ($q) {
            $q->where('name', 'mahasiswa');
        })->orderBy('name')->get();
        return view('admin.academic_schedules.create', compact('programs', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:tugas,diskusi,tuweb,ujian',
            'date' => 'required|date',
            'time' => 'required',
            'deadline' => 'nullable|date',
            'target_semester' => 'nullable|string',
            'prodi_id' => 'nullable|exists:prodis,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        AcademicSchedule::create($validated);
        return redirect()->route('admin.academic-schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(AcademicSchedule $academicSchedule)
    {
        $programs = Prodi::orderBy('nama')->get();
        $students = User::whereHas('role', function ($q) {
            $q->where('name', 'mahasiswa');
        })->orderBy('name')->get();
        return view('admin.academic_schedules.edit', compact('academicSchedule', 'programs', 'students'));
    }

    public function update(Request $request, AcademicSchedule $academicSchedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:tugas,diskusi,tuweb,ujian',
            'date' => 'required|date',
            'time' => 'required',
            'deadline' => 'nullable|date',
            'target_semester' => 'nullable|string',
            'prodi_id' => 'nullable|exists:prodis,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $academicSchedule->update($validated);
        return redirect()->route('admin.academic-schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(AcademicSchedule $academicSchedule)
    {
        $academicSchedule->delete();
        return redirect()->route('admin.academic-schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
