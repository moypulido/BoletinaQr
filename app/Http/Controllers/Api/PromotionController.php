<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Event;
use App\Models\Ticket;
use Exception;

class PromotionController extends Controller
{
    public function index(request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_id' => 'exists:events,id',
                'limit' => 'integer|min:1|max:100',
                'page' => 'integer|min:1',
            ]);
    
            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }
    
            $limit = $request->input('limit', 50);
            $page = $request->input('page', 1);

            if ($request->has('event_id')) {
                $promotions = Promotion::whereHas('events', function ($query) use ($request) {
                    $query->where('events.id', $request->input('event_id'));
                })->with('events')->paginate($limit, ['*'], 'page', $page);
            } else {
                $promotions = Promotion::with('events')->paginate($limit, ['*'], 'page', $page);
            }
            return ApiResponse::paginate('Promotions retrieved successfully', $promotions);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }

    // Show a specific promotion
    public function show($id)
    {
        try {
            $promotion = Promotion::findOrFail($id)->load('events');
            return ApiResponse::success('Promotion retrieved successfully', $promotion);
        } catch (Exception $e) {
            return ApiResponse::error('Promotion not found', 404);
        }
    }

    // Create a new promotion
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|max:255',
                'type' => 'required|string|in:buy_x_get_y,fixed_price,discount_percentage',
                'discount_percentage' => 'nullable|numeric|min:0|max:100',
                'buy_quantity' => 'nullable|integer|min:1',
                'get_quantity' => 'nullable|integer|min:1',
                'fixed_price' => 'nullable|numeric|min:0',
                'valid_from' => 'required|date',
                'valid_until' => 'required|date|after_or_equal:valid_from',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }

            $promotion = Promotion::create($request->all());
            return ApiResponse::success('Promotion created successfully', $promotion, 201);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }

    // Update a specific promotion
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'string|max:255',
                'type' => 'string|in:buy_x_get_y,fixed_price,discount_percentage',
                'discount_percentage' => 'nullable|numeric|min:0|max:100',
                'buy_quantity' => 'nullable|integer|min:1',
                'get_quantity' => 'nullable|integer|min:1',
                'fixed_price' => 'nullable|numeric|min:0',
                'valid_from' => 'date',
                'valid_until' => 'date|after_or_equal:valid_from',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }

            $promotion = Promotion::findOrFail($id);
            $promotion->update($request->all());
            return ApiResponse::success('Promotion updated successfully', $promotion);
        } catch (Exception $e) {
            return ApiResponse::error('Promotion not found or update failed', 404);
        }
    }

    // Delete a specific promotion
    public function destroy($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            $promotion->delete();
            return ApiResponse::success('Promotion deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Promotion not found or delete failed', 404);
        }
    }

    // Attach a promotion to an event
    public function attachEvent(Request $request, $promotionId, $eventId)
    {
        try {
            $promotion = Promotion::findOrFail($promotionId);
            $event = Event::findOrFail($eventId);
            $promotion->events()->attach($event); 
            return ApiResponse::success('Event attached to promotion successfully' , $promotion);
        } catch (Exception $e) {
            return ApiResponse::error('Promotion or Event not found', 404);
        }
    }

    // Detach a promotion from an event
    public function detachEvent(Request $request, $promotionId, $eventId)
    {
        try {
            $promotion = Promotion::findOrFail($promotionId);
            $event = Event::findOrFail($eventId);
            $promotion->events()->detach($event);
            return ApiResponse::success('Event detached from promotion successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Promotion or Event not found', 404);
        }
    }

    // Attach a promotion to a ticket
    public function attachTicket(Request $request, $promotionId, $ticketId)
    {
        try {
            $promotion = Promotion::findOrFail($promotionId);
            $ticket = Ticket::findOrFail($ticketId);
            $promotion->tickets()->attach($ticket);
            return ApiResponse::success('Ticket attached to promotion successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Promotion or Ticket not found', 404);
        }
    }

    // Detach a promotion from a ticket
    public function detachTicket(Request $request, $promotionId, $ticketId)
    {
        try {
            $promotion = Promotion::findOrFail($promotionId);
            $ticket = Ticket::findOrFail($ticketId);
            $promotion->tickets()->detach($ticket);
            return ApiResponse::success('Ticket detached from promotion successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Promotion or Ticket not found', 404);
        }
    }
}