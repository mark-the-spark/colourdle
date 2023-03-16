<?php

use App\Http\Controllers\AttemptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/attempts', [AttemptController::class, 'store']);
Route::get('/attempts/average', [AttemptController::class, 'getAverageAttemptsToday']);
