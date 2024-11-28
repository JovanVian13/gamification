<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\AdminDashboardController;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\VoucherController;

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


Route::get('/task', [TaskController::class, 'index'])->name('tasks');
Route::post('/task/{id}/complete', [TaskController::class, 'completeTask'])->name('tasks.complete');



// Dashboard routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/dashboard/user', [UserDashboardController::class, 'index'])->name('user.dashboard');
});


Route::middleware('auth')->group(function () {
    // Show vouchers and redemption history
    Route::get('/redeem-vouchers', [VoucherController::class, 'showVouchers'])->name('voucher.redeem');

    // Redeem a voucher
    Route::post('/redeem-voucher/{voucherId}', [VoucherController::class, 'redeemVoucher'])->name('voucher.redeem.action');
});




Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');

    // Route for editing the user's profile
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/users', [AdminDashboardController::class, 'manageUsers'])->name('admin.users');
Route::get('/admin/users/{id}/edit', [AdminDashboardController::class, 'useredit'])->name('admin.useredit');

use App\Http\Controllers\VoucherController;

// Route untuk menampilkan daftar voucher dan riwayat penukaran
Route::get('/vouchers', [VoucherController::class, 'showVouchers'])->name('vouchers.index');

// Route untuk menukarkan voucher
Route::post('/vouchers/redeem/{voucherId}', [VoucherController::class, 'redeemVoucher'])->name('vouchers.redeem');

Route::get('/tasks/manage', [AdminDashboardController::class, 'manageTasks'])->name('admin.tasks');
Route::get('/tasks/create', [AdminDashboardController::class, 'createTask'])->name('admin.taskcreate');
Route::post('/tasks/manage', [AdminDashboardController::class, 'storeTask'])->name('admin.taskstore');
Route::get('/tasks/{id}/edit', [AdminDashboardController::class, 'editTask'])->name('admin.taskedit');
Route::put('/tasks/{id}', [AdminDashboardController::class, 'updateTask'])->name('admin.taskupdate');
Route::delete('/tasks/{id}', [AdminDashboardController::class, 'deleteTask'])->name('admin.taskdelete');