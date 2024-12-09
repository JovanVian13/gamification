<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomepageController, RegisterController, LoginController, UserDashboardController, 
    AdminDashboardController, ProfileController, VoucherController, FeedbackController, 
    NotificationController, UserVoucherController, AdminLeaderBoardController, BadgesController, 
    LeaderBoardController, UserTaskController, ReportController, SecurityLogController, 
    SettingsController, TaskManageController, UserManageController, VoucherManageController, 
    AuthController, TestimonialController
};
use App\Http\Middleware\RoleMiddleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Routes for web application
*/

// General Routes
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/faq', [FeedbackController::class, 'showFaq'])->name('faq');
Route::get('/contact', [FeedbackController::class, 'contactSupport'])->name('contact');
Route::post('/testimonials', [TestimonialController::class, 'store'])
    ->middleware('auth')
    ->name('testimonials.store');



// Feedback
Route::get('/feedback', [FeedbackController::class, 'showForm'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');

// Authentication
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot Password
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// User Routes (Authenticated Users)
Route::middleware(['auth', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/dashboard/user', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/leaderboard', [LeaderBoardController::class, 'showLeaderboard'])->name('user.leaderboard');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

// Notifications
Route::get('user/notifications', [NotificationController::class, 'userNotifications'])->name('user.notifications');
Route::post('user/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('user.notifications.read');
Route::delete('user/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('user.notifications.delete');

// Vouchers
Route::middleware('auth')->group(function () {
    Route::get('/redeem-vouchers', [UserVoucherController::class, 'redeemVouchers'])->name('redeem.vouchers');
    Route::post('/redeem-voucher/{voucherId}', [VoucherController::class, 'redeemVoucher'])->name('voucher.redeem.action');
});

// Admin Routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    // Dashboard
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/export/csv', [AdminDashboardController::class, 'exportCSV'])->name('exportcsv');
    Route::get('/export/excel', [AdminDashboardController::class, 'exportExcel'])->name('exportexcel');

    // User Management
    Route::prefix('admin/users')->group(function () {
        Route::get('/', [UserManageController::class, 'manageUsers'])->name('admin.users');
        Route::get('/{id}/edit', [UserManageController::class, 'editUser'])->name('admin.useredit');
        Route::patch('/{id}/update', [UserManageController::class, 'updateUser'])->name('admin.userupdate');
        Route::delete('/{id}', [UserManageController::class, 'deleteuser'])->name('admin.userdelete');
    });

    // Task Management
    Route::prefix('admin/tasks')->group(function () {
        Route::get('/', [TaskManageController::class, 'manageTasks'])->name('admin.tasks');
        Route::get('/create', [TaskManageController::class, 'createTask'])->name('admin.taskcreate');
        Route::post('/manage', [TaskManageController::class, 'storeTask'])->name('admin.taskstore');
        Route::get('/{id}/edit', [TaskManageController::class, 'editTask'])->name('admin.taskedit');
        Route::patch('/{id}', [TaskManageController::class, 'updateTask'])->name('admin.taskupdate');
        Route::post('/assign/{task}', [TaskManageController::class, 'assignTask'])->name('admin.tasksassign');
        Route::delete('/{id}', [TaskManageController::class, 'deleteTask'])->name('admin.taskdelete');
    });

    // Notifications
    Route::prefix('admin/notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'manageNotification'])->name('admin.notification');
        Route::get('/create', [NotificationController::class, 'createNotification'])->name('admin.notificationcreate');
        Route::post('/', [NotificationController::class, 'storeNotification'])->name('admin.notificationstore');
        Route::get('/{id}/edit', [NotificationController::class, 'editNotification'])->name('admin.notificationedit');
        Route::patch('/{id}', [NotificationController::class, 'updateNotification'])->name('admin.notificatioupdate');
        Route::delete('/{id}', [NotificationController::class, 'deleteNotificationAdmin'])->name('admin.notificationdelete');
    });

    // Vouchers
    Route::prefix('admin/vouchers')->group(function () {
        Route::get('/', [VoucherManageController::class, 'manageVoucher'])->name('admin.voucher');
        Route::get('/create', [VoucherManageController::class, 'createVoucher'])->name('admin.vouchercreate');
        Route::post('/', [VoucherManageController::class, 'storeVoucher'])->name('admin.voucherstore');
        Route::get('/{voucher}/edit', [VoucherManageController::class, 'editVoucher'])->name('admin.voucheredit');
        Route::patch('/{voucher}', [VoucherManageController::class, 'updateVoucher'])->name('admin.voucherupdate');
        Route::delete('/{voucher}', [VoucherManageController::class, 'deleteVoucher'])->name('admin.voucherdelete');
    });

    // Leaderboard
    Route::get('/admin/leaderboards', [AdminLeaderBoardController::class, 'showLeaderboard'])->name('admin.leaderboard');

    // Badges
    Route::prefix('admin/badges')->group(function () {
        Route::get('/', [BadgesController::class, 'manageBadges'])->name('admin.badge');
        Route::post('/', [BadgesController::class, 'createBadge'])->name('admin.badgecreate');
        Route::post('/{badge}/assign', [BadgesController::class, 'assignBadge'])->name('admin.badgeassign');
    });
});

// Tasks (User)
Route::middleware(['auth'])->group(function () {
    Route::get('/task', [UserTaskController::class, 'index'])->name('usertask');
    Route::post('/task/{id}/complete', [UserTaskController::class, 'markAsComplete'])->name('usertask.complete');
    Route::post('/video-interaction', [UserTaskController::class, 'trackInteraction'])->name('video.interaction');
});

// Security Logs
Route::prefix('admin/security')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/logs', [SecurityLogController::class, 'index'])->name('admin.securityLogs');
    Route::post('/roles', [SecurityLogController::class, 'storeRole'])->name('admin.roles.store');
    Route::delete('/roles/{role}', [SecurityLogController::class, 'deleteRole'])->name('admin.roles.delete');
});

// Admin Settings
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('admin.settingsupdate');
});