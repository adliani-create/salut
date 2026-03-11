<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Billing;

class BillingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch all billings grouped by semester
        // We only care about UKT and Layanan SALUT for these tabs
        $billings = Billing::where('user_id', $user->id)
            ->whereIn('category', ['UKT', 'Layanan SALUT'])
            ->get()
            ->groupBy('semester');

        // Max semester to show (at least 8)
        // Or should we just show 1-8 hardcoded as per request "Tampilan: Daftar semester 1 sampai 8."?
        // Prompt says "Daftar semester 1 sampai 8". So hardcoded 8 is safer.
        $maxSemester = 8;
        
        return view('mahasiswa.billing.index', compact('user', 'billings', 'maxSemester'));
    }

    public function print($id)
    {
        $billing = Billing::findOrFail($id);

        if ($billing->user_id !== Auth::id()) {
            abort(403);
        }

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

        // Reuse the Admin PDF view as it is generic enough
        // Ensure PDF alias is imported or used fully qualified
        $pdf = \PDF::loadView('admin.billings.invoice_pdf', $data);
        return $pdf->stream('Invoice-' . $billing->billing_code . '.pdf');
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $billing = Billing::findOrFail($id);

        if ($billing->user_id !== Auth::id()) {
            abort(403);
        }

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $billing->update([
                'payment_proof' => $path,
                'status' => 'pending',
                'payment_date' => now(),
                'rejection_reason' => null, // Reset rejection reason on new upload
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }
}
