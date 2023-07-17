<?php
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
