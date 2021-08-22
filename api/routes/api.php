<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

// Auth routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [RegisterUserController::class, 'store']);
Route::post('/login', LoginController::class);
Route::post('/verify', [VerificationController::class, 'verify']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/forgot-password-verify', [ForgotPasswordController::class, 'verifyForgot']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::post('/logout', LogoutController::class);
// end Auth routes

Route::get('/branches', [BranchesController::class, 'index']);
Route::post('/branch/create', [BranchesController::class, 'store']);
Route::post('/branches/{id}', [BranchesController::class, 'show']);
Route::patch('/branch/edit', [BranchesController::class, 'update']);
Route::delete('/branches/{id}', [BranchesController::class, 'destroy']);
// Dashboard
Route::get('/users', [UsersController::class, 'index']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);
Route::get('/all-users', [UsersController::class, 'allUsers']);


Route::get('/messages', [ContactUsController::class, 'index']);
Route::get('/notifications-num', [ContactUsController::class, 'countNotifications']);
Route::post('/messages', [ContactUsController::class, 'shownMessage']);
Route::get('/all-msgs', [ContactUsController::class, 'allMsgs']);
// End Dashboard

Route::post('/contact-us', [ContactUsController::class, 'store']);


