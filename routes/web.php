<?php
/*
 * Project: sunny-backend
 * File: web.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\V1\Api\UserController;

Route::get('/cache-clear', function () {
    $output = "";
    Artisan::call('cache:clear');
    $output .= "<br/>";
    $output .= Artisan::output();
    Artisan::call('view:clear');
    $output .= "<br/>";
    $output .= Artisan::output();
    Artisan::call('route:clear');
    $output .= "<br/>";
    $output .= Artisan::output();
    Artisan::call('config:clear');
    $output .= "<br/>";
    $output .= Artisan::output();

    return $output;
})->name("clear-cache");

Route::get("/users/email/verify/{id}", [UserController::class, "verifyEmailLink"])->name("verification.verify");
