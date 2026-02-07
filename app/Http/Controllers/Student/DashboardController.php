<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AcademicRecord;
use App\Models\TutorialSchedule;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect Maba to Enrollment if status is pending_payment
        if ($user->status === 'pending_payment') {
            return redirect()->route('student.enrollment.step1');
        }

        // 1. BILLING INFO (Overview)
        $totalUnpaid = \App\Models\Billing::where('user_id', $user->id)
            ->whereIn('status', ['unpaid', 'failed'])
            ->sum('amount');
            
        // 2. TRAINING SCHEDULE (Overview - Next 3)
        // 2. TRAINING SCHEDULE (Overview - Next 3)
        // Filter based on Program Pilihan
        $program = optional($user->registration)->fokus_karir;

        $trainings = \App\Models\Training::where('date', '>=', now())
            ->where(function($q) use ($program) {
                // If user has a program, check for match OR general content (no tags)
                if ($program) {
                    $q->whereHas('careerPrograms', function($sq) use ($program) {
                        $sq->where('name', $program);
                    })
                    ->orWhere('program', $program) // Legacy fallback
                    ->orWhereDoesntHave('careerPrograms'); // General content
                } else {
                    // If user has no program, maybe show all or just general? 
                    // Let's show all for now to avoid empty dashboard for old users
                }
            })
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();

        return view('mahasiswa.dashboard', compact('user', 'totalUnpaid', 'trainings'));
    }

    public function academic()
    {
        $user = Auth::user();
        
        // Fetch academic records with grades
        $academicRecords = AcademicRecord::where('user_id', $user->id)
            ->with('grades') // Eager load grades
            ->get();
        
        // Calculate Summary Stats from Real Data
        $totalSks = $academicRecords->sum('sks');
        
        // Calculate Grand Total Points for IPK
        $grandTotalPoints = $academicRecords->reduce(function($carry, $sem) {
             return $carry + $sem->grades->sum(function($course) {
                 return $course->score * $course->sks;
             });
        }, 0);
        
        $ipk = $totalSks > 0 ? $grandTotalPoints / $totalSks : 0;
        
        // Determine Predicate
        $predicate = '-';
        if ($ipk >= 3.51) $predicate = 'Dengan Pujian (Cumlaude)';
        elseif ($ipk >= 3.00) $predicate = 'Sangat Memuaskan';
        elseif ($ipk > 0) $predicate = 'Memuaskan';

        return view('mahasiswa.academic', compact('user', 'academicRecords', 'ipk', 'totalSks', 'predicate'));
    }

    public function nonAcademic()
    {
        $user = Auth::user();
        $program = optional($user->registration)->fokus_karir;

        // Fetch Trainings (Filtered)
        $trainings = \App\Models\Training::where('date', '>=', now())
            ->where(function($q) use ($program) {
                if ($program) {
                    $q->whereHas('careerPrograms', function($sq) use ($program) {
                        $sq->where('name', $program);
                    })
                    ->orWhere('program', $program)
                    ->orWhereDoesntHave('careerPrograms');
                }
            })
            ->orderBy('date', 'asc')
            ->get();

        // Fetch LMS Materials (Filtered)
        $materials = \App\Models\LmsMaterial::latest()
            ->where(function($q) use ($program) {
                if ($program) {
                    $q->whereHas('careerPrograms', function($sq) use ($program) {
                        $sq->where('name', $program);
                    })
                    ->orWhereDoesntHave('careerPrograms');
                }
            })
            ->with(['completions' => function($q) {
                $q->where('user_id', Auth::id());
            }])
            ->get();

        return view('mahasiswa.non-academic', compact('user', 'trainings', 'materials'));
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        
        // Ensure the invoice belongs to the logged-in user
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        return view('mahasiswa.finance.print', compact('invoice'));
    }
}
