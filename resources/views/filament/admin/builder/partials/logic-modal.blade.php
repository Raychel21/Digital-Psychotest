<x-filament::modal id="builder-logic" width="7xl" :close-by-clicking-away="false">
    <x-slot name="heading">Logika tampil</x-slot>
    <x-slot name="description">
        Soal hanya ditampilkan kepada peserta bila rangkaian blok bernilai benar. Kosongkan kanvas untuk selalu menampilkan soal.
    </x-slot>

    <div x-data="logicEditor" x-on:open-modal.window="handleOpen($event)" class="space-y-4">
        <div x-show="loading" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <x-filament::loading-indicator class="h-4 w-4" />
            Memuat editor blok...
        </div>

        <p
            x-show="error"
            x-text="error"
            x-cloak
            class="rounded-lg bg-danger-50 px-3 py-2 text-sm text-danger-700 dark:bg-danger-500/10 dark:text-danger-400"
        ></p>

        <div wire:ignore>
            <div
                x-ref="workspace"
                class="h-[60vh] w-full overflow-hidden rounded-xl border border-gray-200 dark:border-white/10"
            ></div>
        </div>

        <div class="flex items-center justify-between gap-3">
            <x-filament::button color="gray" outlined icon="heroicon-o-trash" x-on:click="clearWorkspace()">
                Bersihkan kanvas
            </x-filament::button>

            <div class="flex items-center gap-2">
                <x-filament::button color="gray" x-on:click="$dispatch('close-modal', { id: 'builder-logic' })">
                    Batal
                </x-filament::button>
                <x-filament::button icon="heroicon-o-check" x-on:click="save()">
                    Simpan logika
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament::modal>
