<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Responses\ApiResponse;

Route::middleware('verify.token')->group(function () {
    Route::apiResource('events', EventController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('promotions', PromotionController::class);

    Route::post('promotions/{promotion}/events/{event}', [PromotionController::class, 'attachEvent']);
    Route::delete('promotions/{promotion}/events/{event}', [PromotionController::class, 'detachEvent']);
    
    Route::post('promotions/{promotion}/tickets/{ticket}', [PromotionController::class, 'attachTicket']);
    Route::delete('promotions/{promotion}/tickets/{ticket}', [PromotionController::class, 'detachTicket']);
});