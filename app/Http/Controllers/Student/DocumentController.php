<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\DocumentController as AdminDocController;

class DocumentController extends Controller
{
    public function downloadKtm()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Only allow download if Admin has uploaded a custom KTM file
        if ($user->ktm_file && Storage::disk('public')->exists($user->ktm_file)) {
            $extension = pathinfo($user->ktm_file, PATHINFO_EXTENSION);
            return Storage::disk('public')->download($user->ktm_file, 'KTM_' . $user->nim . '.' . $extension);
        }

        return back()->with('error', 'KTM kustom dari pusat belum tersedia untuk Anda. Silakan hubungi Admin SALUT.');
    }

    public function downloadKtpu()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->ktpu_status !== 'tersedia' || !$user->ktpu_file) {
            return back()->with('error', 'KTPU Anda belum tersedia untuk diunduh. Silakan hubungi Admin.');
        }

        if (!Storage::disk('public')->exists($user->ktpu_file)) {
            return back()->with('error', 'File KTPU tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($user->ktpu_file, 'KTPU_' . $user->nim . '.pdf');
    }
}
