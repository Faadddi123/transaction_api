<?php

use App\Http\Controllers\authentification_controller;
use App\Http\Controllers\BusinessCard_controller;
use Illuminate\Support\Facades\Route;

// Login Route
Route::post('/login', [authentification_controller::class, 'login']);

// Register Route
Route::post('/register', [authentification_controller::class, 'register']);





Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {

        Route::post('/validateToken', [authentification_controller::class, 'validateToken']);
        // Business Card Routes
        // Create a new business card
        Route::post('/business-cards/store', [BusinessCard_controller::class, 'store']);
        Route::get('/business-cards/show', [BusinessCard_controller::class, 'show']);
        // Get all business cards
        Route::get('/business-cards', [BusinessCard_controller::class, 'index']);
        // Update a business card
        Route::put( '/business-cards/{id}/update', [BusinessCard_controller::class, 'update']);
        // Delete a business card
        Route::delete('/business-cards/{id}/delete', [BusinessCard_controller::class, 'destroy']);
    }
);
