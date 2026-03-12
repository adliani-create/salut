<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('role', function ($q) {
            $q->where('name', 'mahasiswa');
        });

        // Search by name or nim
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.documents.index', compact('students'));
    }

    public function uploadKtpu(Request $request, User $user)
    {
        $request->validate([
            'ktpu_file' => 'required|mimes:pdf|max:2048',
        ]);

        // Delete old file if exists
        if ($user->ktpu_file) {
            Storage::disk('public')->delete($user->ktpu_file);
        }

        $path = $request->file('ktpu_file')->store('documents/ktpu', 'public');

        $user->update([
            'ktpu_file' => $path,
            'ktpu_status' => 'tersedia'
        ]);

        return back()->with('success', "File KTPU untuk {$user->name} berhasil diunggah.");
    }

    public function toggleKtpuStatus(Request $request, User $user)
    {
        $status = $request->input('status', 'pending');
        
        $user->update([
            'ktpu_status' => $status
        ]);

        return back()->with('success', "Status KTPU untuk {$user->name} berhasil diubah menjadi: " . strtoupper($status));
    }

    public function uploadKtm(Request $request, User $user)
    {
        $request->validate([
            'ktm_file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Delete old file if exists
        if ($user->ktm_file) {
            Storage::disk('public')->delete($user->ktm_file);
        }

        $path = $request->file('ktm_file')->store('documents/ktm', 'public');

        $user->update([
            'ktm_file' => $path
        ]);

        return back()->with('success', "File KTM kustom untuk {$user->name} berhasil diunggah.");
    }

    public function generateKtm(User $user)
    {
        // Path to local background image and logo, ensuring offline compatibility for DomPDF via base64
        $logoPath = public_path('images/logo-salut-full.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        // Student photo handling (assuming stored in public disk)
        $photoBase64 = '';
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            $photoPath = Storage::disk('public')->path($user->photo);
            $photoType = pathinfo($photoPath, PATHINFO_EXTENSION);
            $photoData = file_get_contents($photoPath);
            $photoBase64 = 'data:image/' . $photoType . ';base64,' . base64_encode($photoData);
        }

        $pdf = Pdf::loadView('admin.documents.ktm_pdf', compact('user', 'logoBase64', 'photoBase64'));
        
        // KTM is typically Landscape ID card size (CR80 standard is 2.125" x 3.375"), we use custom points
        $customPaper = [0.0, 0.0, 153.0, 243.0]; // approximate 54mm x 85mm portrait or swap for landscape
        // Let's use a standard landscape credit card size (153x243 points ~ 54x85.6 mm)
        $pdf->setPaper($customPaper, 'landscape');

        return $pdf->download('KTM-' . $user->nim . '-' . str_replace(' ', '_', $user->name) . '.pdf');
    }
}
