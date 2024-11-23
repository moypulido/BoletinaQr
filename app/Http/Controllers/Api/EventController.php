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

    /**
     * Display a listing of events.
     *
     * This method handles the retrieval of events based on the request parameters.
     * If a 'name' parameter is provided, it searches for events with names that
     * match the given parameter. If no events are found, it returns a 404 error.
     * Otherwise, it returns the matching events.
     *
     * If no 'name' parameter is provided, it paginates the events based on the
     * 'limit' and 'page' parameters from the request. The default limit is 50
     * and the default page is 1.
     *
     * @param Request $request The request instance containing the parameters.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the events or an error message.
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('name')) {
                $events = Event::where('name', 'like', '%' . $request->name . '%')->get();
                if ($events->isEmpty()) {
                    return ApiResponse::error('No events found', 404);
                }
                return ApiResponse::success('Events retrieved successfully', $events);
            }

            $validator = Validator::make($request->all(), [
                'limit' => 'integer|min:1|max:100',
                'page' => 'integer|min:1',
            ]);
    
            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }

            $limit = $request->input('limit', 50);
            $page = $request->input('page', 1);
    
            $events = Event::paginate($limit, ['*'], 'page', $page);
            return ApiResponse::paginate('Events retrieved successfully', $events);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }
    

    /**
     * Store a newly created event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try{
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

            $event = Event::create($request->all());
            return ApiResponse::success($event, 'Event created successfully', 201);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }


    /**
     * Display the specified event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function show($id)
    {   
        try {
            if (!is_numeric($id)) {
                return ApiResponse::error('Invalid event ID', 400);	
            }
            $event = Event::find($id);
            if (!$event) {
                return ApiResponse::error('Event not found',  404);
            }
            return ApiResponse::success('Event retrieved successfully', $event);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }


    public function update(Request $request, $id)
    {   
        try{

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:events,name,' . $id,
                'description' => 'nullable|string',
                'event_date' => 'required|date',
                'address' => 'required|string|max:255',
                'price' => 'required|numeric',
            ]);
            
            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }
            
            $event = Event::find($id);
            if (!$event) {
                return ApiResponse::error('Event not found', 404);
            }

            $event->update($request->all());
            return ApiResponse::success('Event updated successfully', $event);

        }
        catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }


    }

    public function destroy($id)
    {
        try {
            $event = Event::find($id);
            if (!$event) {
                return ApiResponse::error('Event not found', 404);
            }
            $event->delete();
            return ApiResponse::success('Event deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }
}