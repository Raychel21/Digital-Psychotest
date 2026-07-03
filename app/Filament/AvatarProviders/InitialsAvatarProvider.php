<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Avatar inisial yang dirender lokal sebagai data URI SVG —
 * tanpa memanggil layanan eksternal (pengganti ui-avatars.com).
 */
class InitialsAvatarProvider implements AvatarProvider
{
    public function get(Model|Authenticatable $record): string
    {
        $initials = $this->initials(Filament::getNameForDefaultAvatar($record));

        $svg = <<<SVG
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <rect width="64" height="64" rx="32" fill="#18181b"/>
                <text x="32" y="33" dy=".35em" text-anchor="middle" font-family="Inter, ui-sans-serif, system-ui, sans-serif" font-size="24" font-weight="600" fill="#fafafa">{$initials}</text>
            </svg>
            SVG;

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    private function initials(string $name): string
    {
        return Str::of($name)
            ->squish()
            ->explode(' ')
            ->take(2)
            ->map(fn (string $word): string => Str::upper(Str::substr($word, 0, 1)))
            ->join('');
    }
}
