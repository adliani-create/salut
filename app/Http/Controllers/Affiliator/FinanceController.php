<?php

namespace App\Http\Controllers\Affiliator;

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
        $affiliator = Auth::user();

        $ledgers = PointLedger::where('user_id', $affiliator->id)
            ->with('sourceUser')
            ->latest()
            ->paginate(15);

        return view('affiliator.finance.commissions', compact('ledgers'));
    }

    /**
     * Submit a withdrawal request
     */
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000', // Minimum 50000 points (Rp) to withdraw
        ]);

        $affiliator = Auth::user();

        if (empty($affiliator->bank_name) || empty($affiliator->bank_account) || empty($affiliator->bank_account_owner)) {
            return back()->with('error', 'Lengkapi data Rekening Bank di Profil Anda sebelum melakukan penarikan.');
        }

        // Verify total available points
        if ($affiliator->total_points < $request->amount) {
            return back()->with('error', 'Saldo Poin tidak mencukupi untuk penarikan ini.');
        }

        // Parse single bank account string (e.g., "BCA 12345678 a.n Nama Lengkap") if possible, else just store it inside account_number logic
        // We will store the entire string in account_number or bank_name. Let's put the whole string in bank_name and account_name as same, or map it.
        $bankInfo = $affiliator->bank_account;

        // Create withdrawal record
        $withdrawal = Withdrawal::create([
            'user_id' => $affiliator->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'bank_name' => $affiliator->bank_name,
            'account_number' => $affiliator->bank_account,
            'account_name' => $affiliator->bank_account_owner,
        ]);

        // Create debit ledger entry (deduct points immediately)
        PointLedger::create([
            'user_id' => $affiliator->id, // corrected from $mitra->id
            'type' => 'debit',
            'amount' => $request->amount,
            'description' => 'Penarikan Dana (Menunggu Proses Admin) - #' . $withdrawal->id,
        ]);

        return back()->with('success', 'Permintaan penarikan dana berhasil diajukan dan sedang diproses.');
    }
}
