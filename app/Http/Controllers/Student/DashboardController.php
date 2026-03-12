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

        // Redirect Maba to Enrollment if status is pending_payment (Legacy check)
        if ($user->status === 'pending_payment') {
            return redirect()->route('student.enrollment.step1');
        }

        // Redirect unpaid/inactive students to the Billing page
        if ($user->status !== 'active') {
            return redirect()->route('student.billing.index')->with('warning', 'Akun Anda belum aktif. Selesaikan pembayaran Layanan SALUT untuk membuka akses penuh ke Dashboard.');
        }

        // 1. BILLING INFO (Overview)
        $totalUnpaid = \App\Models\Billing::where('user_id', $user->id)
            ->whereIn('status', ['unpaid', 'failed'])
            ->sum('amount');

        // 2. TRAINING SCHEDULE (Overview - Next 3)
        // 2. TRAINING SCHEDULE (Overview - Next 3)
        // Filter based on Program Pilihan
        $program = optional($user->registration)->fokus_karir;

        $trainings = \App\Models\Training::whereDate('date', '>=', now())
            ->where(function ($q) use ($program) {
                if ($program) {
                    $q->whereHas('careerPrograms', function ($sq) use ($program) {
                        $sq->where('name', $program);
                    })
                        ->orWhere('program', $program) // Legacy fallback
                        ->orWhereDoesntHave('careerPrograms'); // General content
                }
            })
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();

        // 4. ALERTS (H-1 Deadlines)
        $upcomingDeadlines = collect();
        $academicSchedules = collect();
        if ($user->status === 'active') {
            $userSemester = $user->semester;
            $program = optional($user->registration)->fokus_karir;
            
            // Lookup Prodi ID if a program name string is set
            $prodiId = null;
            if ($program) {
                $prodiModel = \App\Models\Prodi::where('nama', $program)->first();
                if ($prodiModel) {
                    $prodiId = $prodiModel->id;
                }
            }
            
            $upcomingDeadlines = \App\Models\AcademicSchedule::whereNotNull('deadline')
                ->whereDate('deadline', '<=', now()->addDay()->toDateString())
                ->whereDate('deadline', '>=', now()->toDateString())
                ->where(function ($query) use ($user, $prodiId, $userSemester) {
                    // Schedules targeted specifically to this student
                    $query->where('user_id', $user->id)
                          // Or schedules meant for everyone matching program & semester
                          ->orWhere(function ($q) use ($prodiId, $userSemester) {
                              $q->whereNull('user_id')
                                ->where(function ($sq) use ($prodiId) {
                                    if ($prodiId) {
                                        $sq->where('prodi_id', $prodiId)
                                           ->orWhereNull('prodi_id');
                                    } else {
                                        $sq->whereNull('prodi_id');
                                    }
                                })
                                ->where(function ($sq) use ($userSemester) {
                                    if ($userSemester) {
                                        $sq->where('target_semester', $userSemester)
                                           ->orWhereNull('target_semester');
                                    } else {
                                        $sq->whereNull('target_semester');
                                    }
                                });
                          });
                })
                ->orderBy('deadline', 'asc')
                ->get();
                
            // Fetch Upcoming Academic Schedules
            $academicSchedules = \App\Models\AcademicSchedule::whereDate('date', '>=', now()->toDateString())
                ->where(function ($query) use ($user, $prodiId, $userSemester) {
                    // Schedules targeted specifically to this student
                    $query->where('user_id', $user->id)
                          // Or schedules meant for everyone matching program & semester
                          ->orWhere(function ($q) use ($prodiId, $userSemester) {
                              $q->whereNull('user_id')
                                ->where(function ($sq) use ($prodiId) {
                                    if ($prodiId) {
                                        $sq->where('prodi_id', $prodiId)
                                           ->orWhereNull('prodi_id');
                                    } else {
                                        $sq->whereNull('prodi_id');
                                    }
                                })
                                ->where(function ($sq) use ($userSemester) {
                                    if ($userSemester) {
                                        $sq->where('target_semester', $userSemester)
                                           ->orWhereNull('target_semester');
                                    } else {
                                        $sq->whereNull('target_semester');
                                    }
                                });
                          });
                })
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->take(5)
                ->get();
                
            // Handle Admission Receipt One-time display
            if (!$user->has_seen_admission_receipt && $user->admission_receipt) {
                // Determine if they just got activated, we show it once, then set to true so next visit it's hidden.
                // We'll pass a flag to the view to show it, and update the DB here.
                $showAdmissionReceiptToast = true;
                $user->update(['has_seen_admission_receipt' => true]);
            }
        }

        $showAdmissionReceiptToast = $showAdmissionReceiptToast ?? false;

        return view('mahasiswa.dashboard', compact('user', 'totalUnpaid', 'trainings', 'upcomingDeadlines', 'academicSchedules', 'showAdmissionReceiptToast'));
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
        $grandTotalPoints = $academicRecords->reduce(function ($carry, $sem) {
            return $carry + $sem->grades->sum(function ($course) {
                return $course->grade_point * $course->sks;
            });
        }, 0);

        $ipk = $totalSks > 0 ? $grandTotalPoints / $totalSks : 0;

        // Determine Predicate
        $predicate = '-';
        if ($ipk >= 3.51)
            $predicate = 'Dengan Pujian (Cumlaude)';
        elseif ($ipk >= 3.00)
            $predicate = 'Sangat Memuaskan';
        elseif ($ipk > 0)
            $predicate = 'Memuaskan';

        return view('mahasiswa.academic', compact('user', 'academicRecords', 'ipk', 'totalSks', 'predicate'));
    }

    public function schedules()
    {
        $user = Auth::user();
        
        // Fetch Academic Schedules for this view
        $program = optional($user->registration)->fokus_karir;
        $userSemester = $user->semester;
        
        // Lookup Prodi ID if a program name string is set
        $prodiId = null;
        if ($program) {
            $prodiModel = \App\Models\Prodi::where('nama', $program)->first();
            if ($prodiModel) {
                $prodiId = $prodiModel->id;
            }
        }
        
        $academicSchedules = \App\Models\AcademicSchedule::whereDate('date', '>=', now()->toDateString())
                ->where(function ($query) use ($user, $prodiId, $userSemester) {
                    // Schedules targeted specifically to this student
                    $query->where('user_id', $user->id)
                          // Or schedules meant for everyone matching program & semester
                          ->orWhere(function ($q) use ($prodiId, $userSemester) {
                              $q->whereNull('user_id')
                                ->where(function ($sq) use ($prodiId) {
                                    if ($prodiId) {
                                        $sq->where('prodi_id', $prodiId)
                                           ->orWhereNull('prodi_id');
                                    } else {
                                        $sq->whereNull('prodi_id');
                                    }
                                })
                                ->where(function ($sq) use ($userSemester) {
                                    if ($userSemester) {
                                        $sq->where('target_semester', $userSemester)
                                           ->orWhereNull('target_semester');
                                    } else {
                                        $sq->whereNull('target_semester');
                                    }
                                });
                          });
                })
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('mahasiswa.schedules', compact('user', 'academicSchedules'));
    }

    public function training()
    {
        $user = Auth::user();
        $program = optional($user->registration)->fokus_karir;

        // Fetch Trainings (Filtered)
        $trainings = \App\Models\Training::whereDate('date', '>=', now())
            ->where(function ($q) use ($program) {
                if ($program) {
                    $q->whereHas('careerPrograms', function ($sq) use ($program) {
                        $sq->where('name', $program);
                    })
                        ->orWhere('program', $program)
                        ->orWhereDoesntHave('careerPrograms');
                }
            })
            ->orderBy('date', 'asc')
            ->get();

        return view('mahasiswa.non-academic.training', compact('user', 'trainings'));
    }

    public function lms()
    {
        $user = Auth::user();
        $program = optional($user->registration)->fokus_karir;

        // Fetch LMS Materials (Filtered)
        $materials = \App\Models\LmsMaterial::latest()
            ->where(function ($q) use ($program) {
                if ($program) {
                    $q->whereHas('careerPrograms', function ($sq) use ($program) {
                        $sq->where('name', $program);
                    })
                        ->orWhereDoesntHave('careerPrograms');
                }
            })
            ->with([
                'completions' => function ($q) {
                    $q->where('user_id', Auth::id());
                }
            ])
            ->get();

        return view('mahasiswa.non-academic.lms', compact('user', 'materials'));
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
