<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderBoardController;
use App\Http\Controllers\FeedbackController;

Route::get('/feedback', [FeedbackController::class, 'showForm'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/faq', [FeedbackController::class, 'showFaq'])->name('faq');
Route::get('/contact', [FeedbackController::class, 'contactSupport'])->name('contact');

// Route ke Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route ke Leaderboard
Route::get('/leaderboard', [LeaderBoardController::class, 'index'])->name('leaderboard');

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', function () {
        return 'Admin Dashboard'; // Replace with admin dashboard view
    })->name('admin.dashboard')->middleware('role:admin');

    Route::get('/dashboard/user', function () {
        return 'User Dashboard'; // Replace with user dashboard view
    })->name('user.dashboard')->middleware('role:user');
});

