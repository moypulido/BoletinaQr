<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $event = Event::create($request->all());

        return response()->json($event, 201);
    }

    public function show($id)
    {
        return Event::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $event = Event::findOrFail($id);
        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}