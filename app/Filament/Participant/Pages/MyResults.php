<?php

namespace App\Filament\Participant\Pages;

use App\Models\Attempt;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class MyResults extends Page
{
    protected static ?string $slug = 'hasil-saya';

    protected static ?string $title = 'Hasil Saya';

    protected static ?string $navigationLabel = 'Hasil Saya';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.participant.pages.my-results';

    /**
     * Seluruh attempt milik peserta yang sedang login, terbaru lebih dulu.
     *
     * @return Collection<int, Attempt>
     */
    public function attempts(): Collection
    {
        return Attempt::query()
            ->where('user_id', auth()->id())
            ->with(['assessment' => fn ($query) => $query->withCount('questions'), 'result'])
            ->withCount('answers')
            ->latest('started_at')
            ->get();
    }
}
