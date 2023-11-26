<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImportJobsCsvController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('jobs', JobController::class)->only([
    'index', 'show'
]);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('jobs/import', ImportJobsCsvController::class);
    Route::resource('jobs', JobController::class)->except([
        'index', 'show'
    ]);
});