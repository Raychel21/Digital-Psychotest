<?php

namespace App\Providers;

use App\Http\Responses\RoleBasedLoginResponse;
use App\Http\Responses\UnifiedLogoutResponse;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoginResponse::class, RoleBasedLoginResponse::class);
        $this->app->bind(LogoutResponse::class, UnifiedLogoutResponse::class);
    }

    public function boot(): void
    {
        //
    }
}
