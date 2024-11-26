<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\TicketController;

Route::middleware('verify.token')->group(function () {
    Route::apiResource('events', EventController::class);
    Route::apiResource('tickets', TicketController::class);
});