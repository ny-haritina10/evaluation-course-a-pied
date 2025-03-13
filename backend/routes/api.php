<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AdminLoginController;
use App\Http\Controllers\Api\EquipeLoginController;
use App\Http\Controllers\Api\DatabaseResetController;
use App\Http\Controllers\Api\CourseEtapeController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/equipe/login', [EquipeLoginController::class, 'login']);

Route::delete('/reset-database', [DatabaseResetController::class, 'reset']);

Route::get('/courses/etapes', [CourseEtapeController::class, 'index']);