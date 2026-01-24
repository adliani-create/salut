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
        // Redirect Maba to Enrollment if status is pending_payment (Initial State)
        // Note: Logic moved to EnrollmentController to set 'active' after Step 2.
        if ($user->status === 'pending_payment') {
            return redirect()->route('student.enrollment.step1');
        }

        // Mock data for dashboard
        $academicRecords = AcademicRecord::where('user_id', $user->id)->get();
        // Fallback mock if empty
        if ($academicRecords->isEmpty()) {
            $academicRecords = [
                 (object)['semester' => '2024.1', 'sks' => 20, 'ips' => 3.50, 'ipk' => 3.50],
                 (object)['semester' => '2024.2', 'sks' => 22, 'ips' => 3.80, 'ipk' => 3.65],
            ];
        }

        $schedules = TutorialSchedule::all(); // Should filter by user's courses/prodi
        
        // Invoices handled by BillingController now.
        $invoices = []; 

        return view('mahasiswa.dashboard', compact('user', 'academicRecords', 'schedules', 'invoices'));
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
