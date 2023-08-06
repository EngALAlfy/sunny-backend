<?php
/*
 * Project: sunny-backend
 * File: api.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

use App\Http\Controllers\V1\Api\AdminController;
use App\Http\Controllers\V1\Api\AuthController;
use App\Http\Controllers\V1\Api\BackupController;
use App\Http\Controllers\V1\Api\BenefitController;
use App\Http\Controllers\V1\Api\DoctorController;
use App\Http\Controllers\V1\Api\PaymentTransactionController;
use App\Http\Controllers\V1\Api\ReservationController;
use App\Http\Controllers\V1\Api\ServiceController;
use App\Http\Controllers\V1\Api\SubscriptionController;
use App\Http\Controllers\V1\Api\UserController;
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
    Route::as("authed.")->middleware('auth:sanctum')->group(function () {
        // Section End-point
        Route::get("/profile", [AuthController::class, "profile"]);
        Route::get("/admins/roles", [AdminController::class, "roles"]);
        Route::get("/doctors/{doctor}/services", [DoctorController::class, "services"]);

        Route::post("/subscriptions/{subscription}/benefits", [SubscriptionController::class, "addBenefit"]);
        Route::delete("/subscriptions/{subscription}/benefits/{benefit}", [SubscriptionController::class, "removeBenefit"]);

        Route::post("/users/{user}/benefits", [UserController::class, "addBenefit"]);
        Route::delete("/users/{user}/benefits/{benefit}", [UserController::class, "removeBenefit"]);

        Route::post("/users/{user}/subscriptions", [UserController::class, "addSubscription"]);
        Route::delete("/users/{user}/subscriptions/{subscription}", [UserController::class, "removeSubscription"]);

        Route::post("/services/{service}/comments", [ServiceController::class, "addComment"]);
        Route::delete("/services/{service}/comments/{serviceComment}", [ServiceController::class, "removeComment"]);

        // Section resources
        Route::apiResource("doctors", DoctorController::class);
        Route::apiResource("services", ServiceController::class);
        Route::apiResource("reservations", ReservationController::class)->except("store");
        Route::apiResource("subscriptions", SubscriptionController::class);
        Route::apiResource("benefits", BenefitController::class);
        Route::apiResource("payment-transactions", PaymentTransactionController::class)->only("index", "store");
        Route::apiResource("backups", BackupController::class)->except("update");
        Route::apiResource("admins", AdminController::class);
        Route::apiResource("users", UserController::class)->except(["store"]);
    });

    // Section non authed APIs
    Route::as("non-authed.")->group(function () {
        Route::post("/reservations", [ReservationController::class, "store"])->name("reservations.store");
    });


});
