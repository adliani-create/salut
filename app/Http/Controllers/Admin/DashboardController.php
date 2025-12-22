<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_fakultas' => Fakultas::count(),
            'total_prodi' => Prodi::count(),
            'total_semester' => Semester::count(),
        ];

        return view('admin.home', compact('stats'));
    }
}
