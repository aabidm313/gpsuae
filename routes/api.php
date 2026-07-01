<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Password reset (bonus)
Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);
Route::post('/password/reset',  [AuthController::class, 'resetPassword']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Events
    Route::get('/events',          [EventController::class, 'index']);
    Route::post('/events',         [EventController::class, 'store']);
    Route::get('/events/{event}',  [EventController::class, 'show']);
    Route::put('/events/{event}',  [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);

    // Participants
    Route::post('/events/{event}/register',   [ParticipantController::class, 'register']);
    Route::delete('/events/{event}/register', [ParticipantController::class, 'unregister']);
    Route::get('/events/{event}/participants', [ParticipantController::class, 'index']);
});
