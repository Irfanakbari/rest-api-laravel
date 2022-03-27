<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsenController;

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

//API route for login user
Route::post('/login', ['as' => 'login', 'uses' => 'App\Http\Controllers\API\AuthController@login']);
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);


//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::resource('/siswa', SiswaController::class)->missing(function (Request $request) {
        return response()->json([
            'status' => 'error',
            'message' => 'Resource not found'
        ], 404);
    });
    Route::resource('/absen', AbsenController::class)->missing(function (Request $request) {
        return response()->json([
            'status' => 'error',
            'message' => 'Resource not found'
        ], 404);
    });
    Route::get('/home', [App\Http\Controllers\API\HomeController::class, 'index']);
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});
