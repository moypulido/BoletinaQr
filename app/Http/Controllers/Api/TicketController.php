<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        return Ticket::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_code' => 'required|string|max:255|unique:tickets,ticket_code',
            'is_used' => 'boolean',
            'qr_code' => 'nullable|string',
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $ticket = Ticket::create($request->all());

        return response()->json($ticket, 201);
    }

    public function show($id)
    {
        return Ticket::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_code' => 'required|string|max:255|unique:tickets,ticket_code,' . $id,
            'is_used' => 'boolean',
            'qr_code' => 'nullable|string',
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());

        return response()->json($ticket);
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}