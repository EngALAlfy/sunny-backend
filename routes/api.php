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
    Route::get('/auth/reset-password/{email}', [AuthController::class, "resetPassword"]);

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

        Route::put("/users/{user}/activate", [UserController::class, "activate"]);
        Route::put("/users/{user}/deactivate", [UserController::class, "deactivate"]);

        Route::put("/users/{user}/email/verify", [UserController::class, "verifyEmail"]);
        Route::put("/users/{user}/email/unverify", [UserController::class, "unVerifyEmail"]);
        Route::put("/users/{user}/email/send", [UserController::class, "sendEmailVerify"]);

        Route::post("/users/{user}/subscriptions", [UserController::class, "addSubscription"]);
        Route::delete("/users/{user}/subscriptions/{subscription}", [UserController::class, "removeSubscription"]);

        Route::post("/services/{service}/comments", [ServiceController::class, "addComment"]);
        Route::delete("/services/{service}/comments/{serviceComment}", [ServiceController::class, "removeComment"]);

        Route::delete("services/{service}/images/{image}", [ServiceController::class, "removeImage"]);
        Route::post("services/{service}/images", [ServiceController::class, "addImage"]);


        Route::get("users/roles/{role}", [UserController::class, "byRole"]);
        Route::post("users/{user}", [UserController::class, "update"]);
        Route::post("admins/{admin}", [AdminController::class, "update"]);
        Route::post("subscriptions/{subscription}", [SubscriptionController::class, "update"]);

        Route::get("payment-transactions/sum/user/{user}", [PaymentTransactionController::class, "getUserSum"]);
        Route::get("payment-transactions/sum/admin/{admin}", [PaymentTransactionController::class, "getAdminSum"]);

        // Section resources
        Route::apiResource("doctors", DoctorController::class);
        Route::apiResource("services", ServiceController::class);
        Route::apiResource("reservations", ReservationController::class)->except("store");
        Route::apiResource("subscriptions", SubscriptionController::class)->except("update");
        Route::apiResource("benefits", BenefitController::class);
        Route::apiResource("payment-transactions", PaymentTransactionController::class)->only("index", "show" ,"store");
        Route::apiResource("backups", BackupController::class)->except("update");
        Route::apiResource("admins", AdminController::class)->except("update");
        Route::apiResource("users", UserController::class)->except(["store", "update"]);
    });

    // Section non authed APIs
    Route::as("non-authed.")->group(function () {
        Route::post("/reservations", [ReservationController::class, "store"])->name("reservations.store");
    });


});
