<?php

namespace App\Providers;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Pagination\Paginator::useTailwind();
        Gate::define('admin', fn (Pengguna $user) => $user->role === Pengguna::ROLE_ADMIN);

        \Illuminate\Support\Facades\View::composer('layouts.admin', function ($view) {
            if (auth()->check()) {
                $notifications = \App\Models\Aktivitas::with('pengguna')
                    ->latest('tanggal_aktivitas')
                    ->take(5)
                    ->get();
                $view->with('notifications', $notifications);
            }
        });
    }
}
