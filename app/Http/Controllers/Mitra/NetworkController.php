<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NetworkController extends Controller
{
    /**
     * Display list of Affiliators recruited by this Mitra
     */
    public function affiliators(Request $request)
    {
        $mitra = Auth::user();
        $search = $request->get('search');

        $affiliators = User::where('referred_by', $mitra->id)
            ->whereHas('role', function($q) { $q->where('name', 'affiliator'); })

            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('referral_code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('mitra.network.affiliators', compact('affiliators', 'search'));
    }
}
