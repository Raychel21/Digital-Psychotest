<?php

namespace App\Http\Responses;

use App\Enums\UserRole;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;

/**
 * Satu pintu login: setelah autentikasi, arahkan pengguna
 * ke panel yang sesuai dengan perannya.
 */
class RoleBasedLoginResponse implements LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $role = Auth::user()?->role;

        $panelId = match ($role) {
            UserRole::Developer => 'developer',
            UserRole::Administrator => 'admin',
            default => 'participant',
        };

        return redirect()->intended(Filament::getPanel($panelId)->getUrl());
    }
}
