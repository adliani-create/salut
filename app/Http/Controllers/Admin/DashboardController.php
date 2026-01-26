<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Billing;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     */
    public function index()
    {
        // General Stats
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_fakultas' => Fakultas::count(),
            'total_prodi' => Prodi::count(),
            'total_semester' => Semester::count(),
        ];

        // Specific Metrics requested
        // 1. Mahasiswa Aktif (Role Mahasiswa + Status Active)
        $active_students = User::whereHas('role', function($q) {
            $q->where('name', 'mahasiswa');
        })->where('status', 'active')->count();

        // 2. Program Pilihan (Group by jalur_pendaftaran from registrations)
        // We join with users to ensure we only count registered users
        $program_distribution = Registration::select('jalur_pendaftaran', DB::raw('count(*) as total'))
            ->groupBy('jalur_pendaftaran')
            ->pluck('total', 'jalur_pendaftaran');

        // 3. Keuangan Pending (Billing Status Pending)
        $pending_bills_count = Billing::where('status', 'pending')->count();

        // 4. Recent Data for Tables
        $recent_users = User::whereHas('role', function($q) {
            $q->where('name', 'mahasiswa');
        })->latest()->take(5)->get();

        $recent_payments = Billing::with('user')->latest()->take(5)->get();

        return view('admin.home', compact(
            'stats', 
            'active_students', 
            'program_distribution', 
            'pending_bills_count', 
            'recent_users', 
            'recent_payments'
        ));
    }
}
