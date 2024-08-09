<?php

namespace App\Providers;

use App\Filament\Auth\MyLogoutResponse;
use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\LogoutResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponse::class, MyLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
