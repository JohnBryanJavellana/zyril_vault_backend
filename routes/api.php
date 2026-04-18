<?php

use App\Http\Controllers\Guest\ForgotPasswordController;
use App\Http\Controllers\Guest\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login-user', [LoginController::class, 'login_user']);
Route::post('/submit-email', [ForgotPasswordController::class, 'submit_email']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset_password']);

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});
