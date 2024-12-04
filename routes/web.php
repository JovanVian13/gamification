<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\http\Middleware\RoleMiddleware;
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
use App\Http\Controllers\UserTaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SecurityLogController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskManageController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\VoucherManageController;
use App\Http\Controllers\AuthController;
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


// Forgot Password
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Reset Password
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


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
    Route::get('/export/csv', [AdminDashboardController::class, 'exportCSV'])->name('exportcsv');
    Route::get('/export/excel', [AdminDashboardController::class, 'exportExcel'])->name('exportexcel');

    // Rute untuk manajemen user
    Route::get('admin/users', [UserManageController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [UserManageController::class, 'editUser'])->name('admin.useredit');
    Route::patch('/admin/users/{id}/update', [UserManageController::class, 'updateUser'])->name('admin.userupdate');
    Route::delete('/admin/users/{id}', [UserManageController::class, 'deleteuser'])->name('admin.userdelete');

    // Rute untuk manajemen tugas
    Route::get('admin/tasks', [TaskManageController::class, 'manageTasks'])->name('admin.tasks');
    Route::get('admin/tasks/create', [TaskManageController::class, 'createTask'])->name('admin.taskcreate');
    Route::post('admin/tasks/manage', [TaskManageController::class, 'storeTask'])->name('admin.taskstore');
    Route::get('/admin/tasks/{id}/edit', [TaskManageController::class, 'editTask'])->name('admin.taskedit');
    Route::patch('admin/tasks/{id}', [TaskManageController::class, 'updateTask'])->name('admin.taskupdate');
    Route::post('admin/tasks/assign/{task}', [TaskManageController::class, 'assignTask'])->name('admin.tasksassign');
    Route::delete('admin/tasks/{id}', [TaskManageController::class, 'deleteTask'])->name('admin.taskdelete');

    // Rute untuk manajemen notification
    Route::get('admin/notifications', [NotificationController::class, 'manageNotification'])->name('admin.notification');
    Route::get('admin/notifications/create', [NotificationController::class, 'createNotification'])->name('admin.notificationcreate');
    Route::post('admin/notifications', [NotificationController::class, 'storeNotification'])->name('admin.notificationstore');
    Route::get('admin/notifications/{id}/edit', [NotificationController::class, 'editNotification'])->name('admin.notificationedit');
    Route::patch('admin/notifications/{id}', [NotificationController::class, 'updateNotification'])->name('admin.notificatioupdate');
    Route::delete('admin/notifications/{id}', [NotificationController::class, 'deleteNotificationAdmin'])->name('admin.notificationdelete');
    

    // Voucher Management
    Route::get('admin/vouchers', [VoucherManageController::class, 'manageVoucher'])->name('admin.voucher');
    Route::get('admin/vouchers/create', [VoucherManageController::class, 'createVoucher'])->name('admin.vouchercreate');
    Route::post('admin/vouchers', [VoucherManageController::class, 'storeVoucher'])->name('admin.voucherstore');
    Route::get('admin/vouchers/{voucher}/edit', [VoucherManageController::class, 'editVoucher'])->name('admin.voucheredit');
    Route::patch('admin/vouchers/{voucher}', [VoucherManageController::class, 'updateVoucher'])->name('admin.voucherupdate');
    Route::delete('admin/vouchers/{voucher}', [VoucherManageController::class, 'deleteVoucher'])->name('admin.voucherdelete');
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

Route::middleware(['auth'])->group(function () {
    Route::get('/task', [UserTaskController::class, 'index'])->name('usertask'); // URL: /tasks
    Route::post('/task/{id}/complete', [UserTaskController::class, 'markAsComplete'])->name('usertask.complete');
    Route::post('/video-interaction', [UserTaskController::class, 'trackInteraction'])->name('video.interaction');
});


Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/security-logs', [SecurityLogController::class, 'index'])->name('admin.securityLogs');
    Route::post('/roles', [SecurityLogController::class, 'storeRole'])->name('admin.roles.store');
    Route::delete('/roles/{role}', [SecurityLogController::class, 'deleteRole'])->name('admin.roles.delete');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('settings', [SettingsController::class, 'update'])->name('settingsupdate');
});