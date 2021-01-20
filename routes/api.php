<?php

use App\Http\Controllers\API\ManufacturerController;
use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
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

Route::get('notauthorized', [\App\Http\Controllers\API\NotAuthorizedController::class, 'notAuthorized'])->name('notauthorized');
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::resource('manufacturers', ManufacturerController::class)->only(['index','show']);
Route::resource('products', ProductController::class)->only(['index','show']);
Route::resource('categories', CategoryController::class)->only(['index','show']);

Route::middleware('auth:api')->group(function () {
    Route::get('get-user', [PassportAuthController::class, 'userInfo']);
    Route::middleware('administrate')->group(function() {
        Route::resource('manufacturers', ManufacturerController::class)->except(['index','show']);
        Route::resource('categories', CategoryController::class)->except(['index','show']);
        Route::resource('products', ProductController::class)->except(['index','show']);
    });
});
