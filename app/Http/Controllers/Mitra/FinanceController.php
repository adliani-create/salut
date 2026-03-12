<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PointLedger;
use App\Models\Withdrawal;

class FinanceController extends Controller
{
    /**
     * View Commission History
     */
    public function commissions()
    {
        $mitra = Auth::user();

        $ledgers = PointLedger::where('user_id', $mitra->id)
            ->with('sourceUser')
            ->latest()
            ->paginate(15);

        return view('mitra.finance.commissions', compact('ledgers'));
    }

    /**
     * Submit a withdrawal request
     */
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50', // Minimum 50 points to withdraw
        ]);

        $mitra = Auth::user();
        $mitraProfile = $mitra->mitraProfile;

        if (!$mitraProfile || !$mitraProfile->bank_number) {
            return back()->with('error', 'Lengkapi data Bank di Profil Anda sebelum melakukan penarikan.');
        }

        // Verify total available points
        if ($mitra->total_points < $request->amount) {
            return back()->with('error', 'Saldo Poin tidak mencukupi untuk penarikan ini.');
        }

        // Create withdrawal record
        $withdrawal = Withdrawal::create([
            'user_id' => $mitra->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'bank_name' => $mitraProfile->bank_name,
            'account_number' => $mitraProfile->bank_number,
            'account_name' => $mitraProfile->bank_account_name,
        ]);

        // Create debit ledger entry (deduct ponts immediately)
        PointLedger::create([
            'user_id' => $mitra->id,
            'type' => 'debit',
            'amount' => $request->amount,
            'description' => 'Penarikan Dana (Pending) - #' . $withdrawal->id,
        ]);

        return back()->with('success', 'Permintaan penarikan dana berhasil diajukan dan sedang diproses.');
    }
}
