<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\http\Middleware\RoleMiddleware;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserVoucherController;
use App\Http\Controllers\AdminLeaderBoardController;
use App\Http\Controllers\BadgesController;
use App\Http\Controllers\LeaderBoardController;

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


Route::get('/feedback', [FeedbackController::class, 'showForm'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/faq', [FeedbackController::class, 'showFaq'])->name('faq');
Route::get('/contact', [FeedbackController::class, 'contactSupport'])->name('contact');

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/dashboard/user', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/leaderboard', [LeaderBoardController::class, 'showLeaderboard'])->name('user.leaderboard');
});

Route::middleware('auth')->group(function () {
    // Show vouchers and redemption history
    Route::get('/redeem-vouchers', [VoucherController::class, 'showVouchers'])->name('voucher.redeem');

    // Redeem a voucher
    Route::post('/redeem-voucher/{voucherId}', [VoucherController::class, 'redeemVoucher'])->name('voucher.redeem.action');
});

Route::get('/redeem-vouchers', [UserVoucherController::class, 'redeemVouchers'])->name('redeem.vouchers');


// Halaman forgot password
Route::get('forgot-password', [LoginController::class, 'showForgot'])->name('password.request');

// Kirim link reset password
Route::post('forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');

// Halaman reset password
Route::get('reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');

// Proses reset password
Route::post('reset-password', [LoginController::class, 'resetPassword'])->name('password.update');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');

    // Route for editing the user's profile
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->name('profile.update');
});


Route::get('user/notifications', [NotificationController::class, 'userNotifications'])->name('user.notifications');
Route::post('user/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('user.notifications.read');
Route::delete('user/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('user.notifications.delete');


// Grup middleware untuk admin
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/users', [AdminDashboardController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [AdminDashboardController::class, 'editUser'])->name('admin.useredit');
    Route::patch('/admin/users/{id}/update', [AdminDashboardController::class, 'updateUser'])->name('admin.userupdate');
    Route::delete('/admin/users/{id}', [AdminDashboardController::class, 'deleteuser'])->name('admin.userdelete');

    // Rute untuk manajemen tugas
    Route::get('admin/tasks', [AdminDashboardController::class, 'manageTasks'])->name('admin.tasks');
    Route::get('admin/tasks/create', [AdminDashboardController::class, 'createTask'])->name('admin.taskcreate');
    Route::post('admin/tasks/manage', [AdminDashboardController::class, 'storeTask'])->name('admin.taskstore');
    Route::get('/admin/tasks/{id}/edit', [AdminDashboardController::class, 'editTask'])->name('admin.taskedit');
    Route::patch('admin/tasks/{id}', [AdminDashboardController::class, 'updateTask'])->name('admin.taskupdate');
    Route::delete('admin/tasks/{id}', [AdminDashboardController::class, 'deleteTask'])->name('admin.taskdelete');

    // Rute untuk manajemen notification
    Route::get('admin/notifications', [NotificationController::class, 'manageNotification'])->name('admin.notification');
    Route::get('admin/notifications/create', [NotificationController::class, 'createNotification'])->name('admin.notificationcreate');
    Route::post('admin/notifications', [NotificationController::class, 'storeNotification'])->name('admin.notificationstore');

    // Voucher Management
    Route::get('admin/vouchers', [AdminDashboardController::class, 'manageVoucher'])->name('admin.voucher');
    Route::get('admin/vouchers/create', [AdminDashboardController::class, 'createVoucher'])->name('admin.vouchercreate');
    Route::post('admin/vouchers', [AdminDashboardController::class, 'storeVoucher'])->name('admin.voucherstore');
    Route::get('admin/vouchers/{voucher}/edit', [AdminDashboardController::class, 'editVoucher'])->name('admin.voucheredit');
    Route::patch('admin/vouchers/{voucher}', [AdminDashboardController::class, 'updateVoucher'])->name('admin.voucherupdate');
    Route::delete('admin/vouchers/{voucher}', [AdminDashboardController::class, 'deleteVoucher'])->name('admin.voucherdelete');
});

// Route untuk menampilkan daftar voucher dan riwayat penukaran
Route::get('/vouchers', [VoucherController::class, 'showVouchers'])->name('vouchers.index');

// Route untuk menukarkan voucher
Route::post('/vouchers/redeem/{voucherId}', [VoucherController::class, 'redeemVoucher'])->name('vouchers.redeem');

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    // Leaderboard
    Route::get('/admin/leaderboards', [AdminLeaderBoardController::class, 'showLeaderboard'])->name('admin.leaderboard');

    // Badge Management
    Route::get('/admin/badges', [BadgesController::class, 'manageBadges'])->name('admin.badge');
    Route::post('/admin/badges', [BadgesController::class, 'createBadge'])->name('admin.badgecreate');
    Route::post('/admin/badges/{badge}/assign', [BadgesController::class, 'assignBadge'])->name('admin.badgeassign');
});


use App\Http\Controllers\UserTaskController;

Route::middleware(['auth'])->group(function () {
    Route::get('/task', [UserTaskController::class, 'index'])->name('usertask'); // URL: /tasks
    Route::post('/task/{id}/complete', [UserTaskController::class, 'markAsComplete'])->name('usertask.complete');
});
