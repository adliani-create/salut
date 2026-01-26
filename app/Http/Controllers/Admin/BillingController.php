<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\User;
use PDF;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    // 1. MONITORING (Main List)
    public function index(Request $request)
    {
        $query = Billing::with('user', 'user.registration');

        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $billings = $query->latest()->paginate(10);
        return view('admin.billings.index', compact('billings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'semester' => 'required|integer',
            'due_date' => 'required|date',
        ]);

        Billing::create([
            'user_id' => $request->user_id,
            'billing_code' => 'INV-' . date('Ym') . '-' . rand(1000, 9999),
            'category' => $request->category,
            'amount' => $request->amount,
            'semester' => $request->semester,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'status' => 'unpaid',
        ]);

        return back()->with('success', 'Tagihan berhasil dibuat.');
    }

    // 2. BULK GENERATION
    public function createBulk()
    {
        // Get unique options from users for filter
        $fakultas = \App\Models\User::whereNotNull('faculty')->distinct()->pluck('faculty');
        // Ideally fetch from Master Data if available, but users table is fine for now
        
        return view('admin.billings.create-bulk', compact('fakultas'));
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'semester' => 'required|integer',
            'due_date' => 'required|date',
            'year' => 'required|integer', // Angkatan (Year of Join)
            // Optional filters
            'faculty' => 'nullable|string',
        ]);

        // Find students
        $query = User::whereHas('role', function($q){ $q->where('name', 'mahasiswa'); })
                     ->where('status', 'active');
        
        // Filter by angkatan (using created_at year as proxy for now, or if we had 'angkatan' column)
        $query->whereYear('created_at', $request->year);

        if($request->faculty){
            $query->where('faculty', $request->faculty);
        }

        $students = $query->get();
        $count = 0;

        foreach ($students as $student) {
            // Check if billing already exists for this semester & category
            $exists = Billing::where('user_id', $student->id)
                             ->where('category', $request->category)
                             ->where('semester', $request->semester)
                             ->exists();
            
            if (!$exists) {
                Billing::create([
                    'user_id' => $student->id,
                    'billing_code' => 'INV-' . date('Ym') . '-' . rand(1000, 9999), 
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'semester' => $request->semester,
                    'due_date' => $request->due_date,
                    'status' => 'unpaid',
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.billings.index')->with('success', "$count Tagihan berhasil digenerate.");
    }

    // 3. VERIFICATION
    public function verification()
    {
        $billings = Billing::with('user')
                           ->where('status', 'pending')
                           ->orderBy('payment_date', 'asc')
                           ->get();
        return view('admin.billings.verification', compact('billings'));
    }

    public function approve(Billing $billing)
    {
        $billing->update([
            'status' => 'paid',
            'verified_at' => now(),
        ]);
        
        // Audit log could go here
        
        return back()->with('success', 'Pembayaran diterima.');
    }

    public function manualVerify(Request $request, Billing $billing)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'reference_number' => 'required|string',
            'admin_note' => 'nullable|string',
        ]);

        $description = "Ref: " . $request->reference_number;
        if($request->admin_note){
            $description .= " | Note: " . $request->admin_note;
        }

        $billing->update([
            'status' => 'paid',
            'payment_date' => $request->payment_date,
            'verified_at' => now(),
            'description' => $description, // Use existing description field
            // Rejection reason cleared just in case
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi secara manual.');
    }

    public function reject(Request $request, Billing $billing)
    {
        $billing->update([
            'status' => 'failed', // Or 'unpaid' if you want them to try again immediately
            'rejection_reason' => $request->reason,
        ]);
        
        return back()->with('info', 'Pembayaran ditolak.');
    }
    
    // 4. PRINTING
    public function printInvoice(Billing $billing)
    {
        // Ensure relation is loaded
        $billing->load('user', 'user.registration');

        $data = [
            'billing' => $billing,
            'title' => $billing->status == 'paid' ? 'Kuitansi Pembayaran' : 'Invoice Tagihan',
        ];

        $pdf = Pdf::loadView('admin.billings.invoice_pdf', $data);
        return $pdf->stream('Invoice-' . $billing->billing_code . '.pdf');
    }

    // 5. LEDGER / KARTU KONTROL
    public function ledger(\App\Models\User $user)
    {
        $user->load('registration');
        
        // Fetch all billings grouped by semester
        $billings = Billing::where('user_id', $user->id)
            ->whereIn('category', ['UKT', 'Layanan SALUT'])
            ->get()
            ->groupBy('semester');

        // Determine max semester (at least 8)
        $maxSemester = max(8, $user->semester, $billings->keys()->max() ?? 0);

        return view('admin.billings.ledger', compact('user', 'billings', 'maxSemester'));
    }
}
