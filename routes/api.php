<?php

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

use App\Http\Controllers\SitesController;
use App\Http\Controllers\SitePostsController;
use App\Http\Controllers\SubscribersController;
 
Route::controller(SitesController::class)->group(function () {
    Route::get('/sites', 'show');
});
 
Route::controller(SitePostsController::class)->group(function () {
    Route::get('/site-posts', 'show');
    Route::post('/site-posts', 'store');
});
 
Route::controller(SubscribersController::class)->group(function () {
    Route::get('/subscribers', 'show');
    Route::post('/subscribers', 'store');
    Route::post('/subscribers/subscribe-site', 'subscribeSite');
});