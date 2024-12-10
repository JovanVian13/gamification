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
                $notifications = Notification::where('user_id', Auth::id())
                    ->latest()
                    ->take(3)
                    ->get();
            } else {
                $notifications = collect(); // Empty collection if not authenticated
            }
    
            $view->with('notifications', $notifications);
        });

        Paginator::useBootstrap();
    }
}
