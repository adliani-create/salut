<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CareerProgram;
use App\Models\User;
use App\Models\Registration;
use App\Models\LmsMaterial;
use App\Models\Training;

class NonAcademicController extends Controller
{
    public function index()
    {
        // Stats for Monitoring
        // "Berapa mahasiswa yang memilih program Wirausaha?", etc.
        // We need to count users based on 'fokus_karir' in their registration.
        // Or if we normalized it, count by relationship. 
        // Currently 'fokus_karir' is a string in Registration table.
        // But we want to map it to CareerProgram names if possible, or just raw group by.
        
        $stats = [];
        $programs = CareerProgram::all();
        
        foreach($programs as $program) {
            // Count from Registration where fokus_karir matches program name
            // Note: This relies on string matching which is fragile if names change, 
            // but currently the registration uses string. 
            // Ideally we migrate registration to use career_program_id.
            // For now, matching by name.
            $count = Registration::where('fokus_karir', $program->name)->count();
            $stats[] = [
                'name' => $program->name,
                'count' => $count,
                'icon' => $this->getProgramIcon($program->name),
                'color' => $this->getProgramColor($program->name),
            ];
        }

        $totalMaterials = LmsMaterial::count();
        $totalTrainings = Training::count();

        return view('admin.non-academic.index', compact('stats', 'totalMaterials', 'totalTrainings'));
    }

    private function getProgramIcon($name) {
        if(str_contains($name, 'Wirausaha')) return 'bi-rocket-takeoff';
        if(str_contains($name, 'Magang')) return 'bi-building';
        if(str_contains($name, 'Skill')) return 'bi-laptop';
        if(str_contains($name, 'Creator')) return 'bi-phone';
        return 'bi-mortarboard';
    }

    private function getProgramColor($name) {
        if(str_contains($name, 'Wirausaha')) return 'success';
        if(str_contains($name, 'Magang')) return 'primary';
        if(str_contains($name, 'Skill')) return 'info';
        if(str_contains($name, 'Creator')) return 'warning';
        return 'secondary';
    }
}
