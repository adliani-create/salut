<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentTrack;
use App\Models\Invoice;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    public function step1()
    {
        // Biodata / Confirmation
        return view('mahasiswa.enrollment.step1');
    }

    public function storeStep1(Request $request)
    {
        // Update user details if needed
        return redirect()->route('student.enrollment.step2');
    }

    public function step2()
    {
        // Non-Academic Track Selection
        return view('mahasiswa.enrollment.step2');
    }

    public function storeStep2(Request $request)
    {
        $request->validate([
            'track_name' => 'required|string',
        ]);

        $user = Auth::user();
        
        StudentTrack::create([
            'user_id' => $user->id,
            'track_name' => $request->track_name,
            'selected_at' => now(),
        ]);

        // Generate Admission Invoice but don't force payment
        $invoice = Invoice::where('user_id', $user->id)->where('title', 'Biaya Admisi')->first();
        if (!$invoice) {
            Invoice::create([
                'user_id' => $user->id,
                'title' => 'Biaya Admisi',
                'amount' => 500000, 
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(7),
            ]);
        }

        // Activate user immediately to allow dashboard access
        $user->update(['status' => 'active']);

        return redirect()->route('student.dashboard')->with('success', 'Enrollment Complete! Access your dashboard.');
    }

}
