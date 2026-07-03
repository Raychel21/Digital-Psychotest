<?php

namespace App\Providers;

use App\Http\Responses\RoleBasedLoginResponse;
use App\Http\Responses\UnifiedLogoutResponse;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
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
        $this->configureDateDisplayFormats();
        $this->configureNonNativeControls();
    }

    /**
     * Semua dropdown dan date picker memakai UI kustom Filament,
     * bukan kontrol native browser, agar tampilan konsisten lintas OS.
     */
    private function configureNonNativeControls(): void
    {
        Select::configureUsing(fn (Select $select) => $select->native(false));
        SelectFilter::configureUsing(fn (SelectFilter $filter) => $filter->native(false));
        DatePicker::configureUsing(fn (DatePicker $picker) => $picker->native(false));
    }

    /**
     * Tanggal di tabel & infolist tampil gaya Indonesia ("3 Jul 2026, 11.15")
     * memakai translatedFormat, mengikuti APP_LOCALE=id.
     */
    private function configureDateDisplayFormats(): void
    {
        Table::configureUsing(fn (Table $table) => $table
            ->defaultDateDisplayFormat('j M Y')
            ->defaultDateTimeDisplayFormat('j M Y, H:i'));

        Schema::configureUsing(fn (Schema $schema) => $schema
            ->defaultDateDisplayFormat('j M Y')
            ->defaultDateTimeDisplayFormat('j M Y, H:i'));
    }
}
