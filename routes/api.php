<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
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

Route::middleware('auth:sanctum')->get('/user', [userController::class, 'user']);
Route::post("/login",[userController::class,"login"]);
Route::post("/adduser",[userController::class,"adduser"]);
Route::delete("/deleteuser/{id}",[userController::class,"delete"]);
Route::post("/logout",[userController::class,"logout"]);
