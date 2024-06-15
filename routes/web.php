<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsController;

Route::get('/', [NewsController::class, 'index']);
Route::get('/2', [NewsController::class, 'index2']);
Route::get('/get-data', [NewsController::class, 'getData']);
