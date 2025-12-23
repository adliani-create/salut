<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = \App\Models\SupportTicket::with('user')->orderBy('updated_at', 'desc')->get();
        return view('staff.tickets.index', compact('tickets'));
    }

    public function show(\App\Models\SupportTicket $ticket)
    {
        $ticket->load('replies.user');
        return view('staff.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, \App\Models\SupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string'
        ]);

        // Create reply
        \App\Models\TicketReply::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $validated['message']
        ]);

        // Update ticket status
        $ticket->update(['status' => 'answered']);

        return back()->with('success', 'Reply sent successfully.');
    }

    public function updateStatus(Request $request, \App\Models\SupportTicket $ticket)
    {
         $validated = $request->validate([
            'status' => 'required|in:open,answered,closed'
        ]);

        $ticket->update(['status' => $validated['status']]);
        return back()->with('success', 'Ticket status updated.');
    }
}
