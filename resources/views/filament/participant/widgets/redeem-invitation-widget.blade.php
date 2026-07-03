<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-o-ticket">
        <x-slot name="heading">Mulai Tes Baru</x-slot>
        <x-slot name="description">Masukkan kode undangan yang Anda terima untuk memulai tes.</x-slot>

        <form wire:submit="redeem" class="flex flex-col gap-3 sm:flex-row sm:items-start">
            <div class="flex-1">
                <x-filament::input.wrapper :valid="! $errors->has('code')">
                    <x-filament::input
                        type="text"
                        wire:model="code"
                        placeholder="Contoh: ABC-123-XYZ"
                        autocomplete="off"
                    />
                </x-filament::input.wrapper>

                @error('code')
                    <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                @enderror
            </div>

            <x-filament::button type="submit" icon="heroicon-o-play" wire:loading.attr="disabled">
                Mulai Tes
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
