<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.userapp', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                // Total unread count
                $totalUnreadCount = Notification::where('user_id', $userId)
                    ->where('read_status', 'unread')
                    ->count();

                // Subset of recent unread notifications (maximum 3)
                $recentUnreadNotifications = Notification::where('user_id', $userId)
                    ->where('read_status', 'unread')
                    ->latest()
                    ->take(3)
                    ->get();

                // Pass data to the view
                $view->with('totalUnreadCount', $totalUnreadCount);
                $view->with('recentUnreadNotifications', $recentUnreadNotifications);
            } else {
                // Default values when user is not authenticated
                $view->with('totalUnreadCount', 0);
                $view->with('recentUnreadNotifications', collect());
            }
        });

        // Use Bootstrap for pagination
        Paginator::useBootstrap();
    }

}
