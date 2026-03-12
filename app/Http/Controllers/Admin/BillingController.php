<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\User;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

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
        
        $this->processLayananSalutActivation($billing);
        
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

        $this->processLayananSalutActivation($billing);

        return back()->with('success', 'Pembayaran berhasil diverifikasi secara manual.');
    }

    /**
     * Helper to activate student if billing is Layanan SALUT
     */
    private function processLayananSalutActivation(Billing $billing)
    {
        if ($billing->category === 'Layanan SALUT') {
            $user = $billing->user;
            
            if ($user) {
                // 1. Activate the user if not already active
                if ($user->status !== 'active') {
                    $user->update(['status' => 'active']);
                }
                
                // 2. Also update the Registration model status to valid
                if ($user->registration && $user->registration->status !== 'valid') {
                    $user->registration->update(['status' => 'valid']);
                }

                // 3. Distribute 50000 points commission to the referrer for this specific semester
                if ($user->referred_by) {
                    $description = 'Komisi Layanan SALUT Semester ' . $billing->semester . ' mahasiswa: ' . $user->name;
                    $alreadyGiven = \App\Models\PointLedger::where('user_id', $user->referred_by)
                        ->where('description', $description)
                        ->where('type', 'credit')
                        ->exists();

                    if (!$alreadyGiven) {
                        $referrer = User::find($user->referred_by);
                        if ($referrer) {
                            \App\Models\PointLedger::create([
                                'user_id' => $referrer->id,
                                'amount' => 50000,
                                'type' => 'credit',
                                'source_id' => $user->id,
                                'description' => $description,
                            ]);
                            // Do not increment missing total_points column
                        }
                    }
                }
            }
        }
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

        // Encode Logo to Base64 for DOMPDF
        $logoPath = public_path('images/logo-salut-full.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        // Encode Signature to Base64
        $sigPath = public_path('images/signature.jpg');
        $signatureBase64 = '';
        if (file_exists($sigPath)) {
            $sigData = file_get_contents($sigPath);
            $sigType = pathinfo($sigPath, PATHINFO_EXTENSION);
            $signatureBase64 = 'data:image/' . $sigType . ';base64,' . base64_encode($sigData);
        }

        $data = [
            'billing' => $billing,
            'title' => $billing->status == 'paid' ? 'Kuitansi Pembayaran' : 'Invoice Tagihan',
            'logo_base64' => $logoBase64,
            'signature_base64' => $signatureBase64
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

    // 6. WHATSAPP NOTIFICATION
    public function sendWhatsappNotification(Billing $billing)
    {
        // 1. Get Data
        $billing->load('user', 'user.registration');
        $user = $billing->user;
        
        // 2. Format Phone Number
        $phone = $user->registration->whatsapp ?? $user->registration->no_hp ?? '';
        if (empty($phone)) {
            return back()->with('error', 'Nomor WhatsApp tidak ditemukan untuk mahasiswa ini.');
        }

        // Sanitize phone number: remove non-numeric, replace leading 0 or 62
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        
        // Add suffix for WAHA
        $chatId = $phone . '@c.us';

        // 3. Generate Invoice PDF File
        try {
            $data = [
                'billing' => $billing,
                'title' => $billing->status == 'paid' ? 'Kuitansi Pembayaran' : 'Invoice Tagihan',
            ];
            
            $pdf = Pdf::loadView('admin.billings.invoice_pdf', $data);
            $filename = 'Invoice-' . $billing->billing_code . '.pdf';
            $path = public_path('invoices');
            
            // Ensure directory exists
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            
            $pdf->save($path . '/' . $filename);
            
            // Public URL for the file
            $fileUrl = asset('invoices/' . $filename);

            // 4. Send Request to WAHA
            $caption = "Halo kak! Tagihan UKT Semester {$billing->semester} sebesar Rp " . number_format($billing->amount, 0, ',', '.') . " belum dibayar. Mohon segera diselesaikan.";

            $wahaUrl = env('WAHA_API_URL', 'http://localhost:3000');
            
            try {
                $response = Http::timeout(5)->post("$wahaUrl/api/sendFile", [
                    'chatId' => $chatId,
                    'caption' => $caption,
                    'file' => [
                        'mimetype' => 'application/pdf',
                        'filename' => $filename,
                        'url' => $fileUrl
                    ],
                    'session' => 'default'
                ]);

                if ($response->successful()) {
                    return back()->with('success', 'Notifikasi WhatsApp berhasil dikirim.');
                } else {
                    return back()->with('error', 'Gagal mengirim WA: ' . $response->body());
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                return back()->with('error', "Gagal terhubung ke Server WAHA ($wahaUrl). Pastikan server berjalan.");
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
