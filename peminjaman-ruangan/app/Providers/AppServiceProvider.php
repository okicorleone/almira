<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    View::composer('layouts.admin', function ($view) {
        if (auth()->check()) {
            $unreadCount = Notification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->count();
        } else {
            $unreadCount = 0;
        }

        $view->with('unreadCount', $unreadCount);
        });
    }
}