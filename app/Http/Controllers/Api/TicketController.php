<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Ticket;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use App\Models\Event;
use Faker\Factory as Faker;

use Exception;

class TicketController extends Controller
{
    protected $faker;
    protected $qrCodeOptions;

    public function __construct()
    {
        $this->faker = Faker::create();
        $this->qrCodeOptions = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_H,
            'scale' => 5,
        ]);
    }
    public function index(request $request)	
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|exists:events,id',
                'limit' => 'integer|min:1|max:100',
                'page' => 'integer|min:1',
            ]);
    
            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }
    
            $limit = $request->input('limit', 50);
            $page = $request->input('page', 1);
            $event_id = $request->input('event_id');
    
            $tickets = Ticket::where('event_id', $event_id)
                ->with(['event', 'promotions'])
                ->paginate($limit, ['*'], 'page', $page);
            return ApiResponse::paginate('Tickets retrieved successfully', $tickets);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|exists:events,id',
                'email' => 'nullable|email|max:255',
                'name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }

            $ticket_code = $this->faker->unique()->bothify('TICKET-####-????');

            $request->merge([
                'ticket_code' => $ticket_code,
                'qr_code' => base64_encode((new QRCode($this->qrCodeOptions))->render($ticket_code)),
            ]);

            $ticket = Ticket::create($request->all());
            return ApiResponse::success('Ticket created successfully', $ticket, 201);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 500);
        }
    }

    public function show($id)
    {
        try {
            $ticket = Ticket::findOrFail($id)->load('event')->load('promotions');
            return ApiResponse::success('Ticket retrieved successfully', $ticket);
        } catch (Exception $e) {
            return ApiResponse::error('An unexpected error occurred', 404);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'is_used' => 
                    function ($attribute, $value, $fail) {
                        if ($value != true ) {
                            $fail($attribute.' must be true.');
                        }
                    },
                'status' => 'in:Used',
                'event_id' => 'exists:events,id',
                'email' => 'nullable|email|max:255',
                'name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ];

            $filteredRequest = $request->only(array_keys($rules));

            $extraParams = array_diff_key($request->all(), $filteredRequest);
            if (!empty($extraParams)) {
                return ApiResponse::error('Invalid parameters provided', 400);
            }
    

            $validator = Validator::make($filteredRequest, $rules);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 400);
            }

            $ticket = Ticket::findOrFail($id);

            if ($request->has('is_used') || $request->has('status')) {
                $ticket->markAsUsed();
            }

            $ticket->update($filteredRequest);
            return ApiResponse::success('Ticket updated successfully', $ticket);
        } catch (Exception $e) {
            return ApiResponse::error('Ticket not found or update failed', 404);
        }
    }

    public function destroy($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->delete();
            return ApiResponse::success('Ticket deleted successfully');
        } catch (Exception $e) {
            return ApiResponse::error('Ticket not found or delete failed', 404);
        }
    }

}