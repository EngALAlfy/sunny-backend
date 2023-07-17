<?php

use App\Http\Controllers\V1\Api\AuthController;
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
Route::prefix("v1")->as("v1.")->middleware(['apiLocalization'])->group(function () {

    // Section Auth APIs
    Route::post('/auth/register', [AuthController::class, "register"]);
    Route::post('/auth/login', [AuthController::class, "login"]);

    // Section Authed APIs
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });


});
