<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
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

Route::resource('animals', AnimalController::class);

// Route::get('/animal', function (Request $request) {
//     return "<div>Animals</div>";
// });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/signup', 'signup');
    Route::post('/auth/login', 'login');
    Route::middleware('auth:sanctum')->get('/auth/logout', 'logout');
});
