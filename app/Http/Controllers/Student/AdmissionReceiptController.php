<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdmissionReceiptController extends Controller
{
    /**
     * Unduh Lembar Informasi Pembayaran (PDF)
     */
    public function download()
    {
        $user = Auth::user();

        // Security check, must be active
        if ($user->status !== 'active') {
             return redirect()->route('student.dashboard')->with('error', 'Status akun Anda belum aktif, kuitansi belum dapat diunduh.');
        }

        // Fetch Registration specific data safely
        $registration = $user->registration;
        
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
            'nama' => strtoupper($user->name),
            'nim' => $user->nim ?? '-',
            'prodi' => $user->major ?? ($registration ? $registration->program_studi : '-'),
            'masa_registrasi' => '2026 Ganjil', // In a real app this is dynamic, matching user screenshot
            'semester' => 'Semester 1',
            'no_ref' => 'INV-' . date('Ym', strtotime($user->created_at)) . '-' . rand(1000, 9999),
            'logo_base64' => $logoBase64,
            'signature_base64' => $signatureBase64
        ];

        // Format PDF Name
        $pdfFileName = 'Lembar_Pembayaran_Admisi_' . str_replace(' ', '_', $user->name) . '.pdf';

        // Load View
        $pdf = Pdf::loadView('student.admission.receipt_pdf', $data);
        
        // Optional Setup Paper (A4 portrait)
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download($pdfFileName);
    }
}
