<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\PointLedger;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $withdrawals = Withdrawal::with('user', 'processor')
            ->when($status !== 'all', function($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(15);
            
        return view('admin.withdrawals.index', compact('withdrawals', 'status'));
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Pencairan ini sudah diproses.');
        }

        // Deduct points since it's approved. 
        // Best practice: The points were already in the user's "pending" balance, 
        // but since we only have a simple ledger, we enter a Debit when Approved.
        // Wait, if it's already deducted when requested, we don't deduct again.
        // Let's assume points are deducted WHEN REQUESTED. 
        // If rejected, we refund the points. 
        // We will finalize this logic here.

        $withdrawal->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'notes' => $request->notes ?? 'Pencairan disetujui dan ditransfer.',
        ]);

        return back()->with('success', 'Pencairan disetujui dan ditandai selesai.');
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Pencairan ini sudah diproses.');
        }

        $request->validate([
            'notes' => 'required|string',
        ]);

        // Refund the points back to user's ledger
        PointLedger::create([
            'user_id' => $withdrawal->user_id,
            'type' => 'credit',
            'amount' => $withdrawal->amount,
            'description' => 'Pengembalian poin karena pencairan ditolak. ID: ' . $withdrawal->id,
        ]);

        $withdrawal->update([
            'status' => 'rejected',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Pencairan ditolak dan poin dikembalikan ke saldo mitra.');
    }
}
