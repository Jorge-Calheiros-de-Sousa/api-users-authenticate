<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, "register"]);
Route::post('/auth/login', [AuthController::class, "login"]);
Route::middleware("auth:sanctum")->post('/auth/logout', [AuthController::class, "logOut"]);

Route::middleware("auth:sanctum")->put('/user/{user}', [UserController::class, "update"]);
Route::middleware("auth:sanctum")->delete('/user/{user}', [UserController::class, "destroy"]);
Route::middleware("auth:sanctum")->get('/adm/users', [UserController::class, "index"]);
Route::middleware("auth:sanctum")->get('/adm/users/{user}', [UserController::class, "show"]);
