<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LmsMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LmsController extends Controller
{
    /**
     * Mark material as complete and redirect to file.
     */
    public function view(LmsMaterial $material)
    {
        // Mark as completed for the authenticated user
        if (!Auth::user()->completedMaterials->contains($material->id)) {
            Auth::user()->completedMaterials()->attach($material->id, ['completed_at' => now()]);
        }

        // Return the file path to open/download
        return redirect(asset('storage/' . $material->file_path));
    }
}
