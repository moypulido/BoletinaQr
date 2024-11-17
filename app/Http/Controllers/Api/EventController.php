<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Event;
use Exception;

class EventController extends Controller
{
    public function index()
    { 
        $Events = Event::all();
        if ($Events->isEmpty()) {
            return ApiResponse::error('No events found', 404);
        }
        return ApiResponse::success('Events retrieved successfully', $Events);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:events,name',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 400);
        }

        try{
            $event = Event::create($request->all());
            return ApiResponse::success($event, 'Event created successfully', 201);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
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