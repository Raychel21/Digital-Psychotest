<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Illuminate\Http\RedirectResponse;

class UnifiedLogoutResponse implements LogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        return redirect()->route('login');
    }
}
