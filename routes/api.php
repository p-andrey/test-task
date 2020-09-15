<?php

use App\Http\Controllers\StolenCarController;
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

// todo maybe use auth:api middleware
Route::apiResource('stolen-cars', StolenCarController::class)->except('show');
