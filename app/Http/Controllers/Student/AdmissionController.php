<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmissionController extends Controller
{
    /**
     * Menampilkan halaman tagihan admisi
     */
    public function pay()
    {
        $user = auth()->user();
        return view('student.admission.pay', compact('user'));
    }

    /**
     * Memproses upload bukti transfer
     */
    public function upload(Request $request)
    {
        $request->validate([
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB Image
        ]);

        $user = auth()->user();

        if ($request->hasFile('payment_receipt')) {
            $path = $request->file('payment_receipt')->store('admissions', 'public');
            
            // Simpan path ke user
            $user->admission_receipt = $path;
            
            // Ubah status agar tulisan di frontend berubah jadi "Menunggu Verifikasi"
            $user->status = 'pending_verification';
            $user->save();

            return redirect()->route('student.admission.pay')->with('success', 'Bukti transfer berhasil diunggah. Silakan tunggu verifikasi dari Admin.');
        }

        return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }
}
