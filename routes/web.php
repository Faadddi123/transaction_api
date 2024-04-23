<?php

use App\Http\Controllers\BusinessCard_controller;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/getusersandstuff', [BusinessCard_controller::class, 'getusersandstuff']);
