<?php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate;

/**
 * Tamu yang menyentuh panel mana pun diarahkan ke satu halaman login: /login.
 */
class RedirectToUnifiedLogin extends Authenticate
{
    protected function redirectTo($request): ?string
    {
        return route('login');
    }
}
