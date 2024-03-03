<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\SidangController;
use App\Http\Controllers\api\StudentController;

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

Route::post('/login', [LoginController::class, "login"]);
Route::get('/sidang', [SidangController::class, "index"]);
Route::get('/sidang/{id}', [SidangController::class, "detail"]);
Route::patch('/sidang/update/{id}', [SidangController::class, "store"]);

Route::post('/peminatans', [SidangController::class, "peminatans"]);
Route::get('/allPeriod', [SidangController::class, "getAllPeriod"]);

// Student
Route::get('/student/{id}', [StudentController::class, "detail"]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return [
        'succes' => "200",
        "data" => $request->user()
    ];
});
