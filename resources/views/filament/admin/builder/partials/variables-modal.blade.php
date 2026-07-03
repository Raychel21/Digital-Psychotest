<x-filament::modal id="builder-variables" width="7xl" :close-by-clicking-away="false">
    <x-slot name="heading">Variabel & Rumus</x-slot>
    <x-slot name="description">
        Definisikan variabel kustom dari skor hasil (raw/norm). Variabel yang lebih dulu didefinisikan bisa dipakai pada rumus berikutnya.
    </x-slot>

    <div x-data="variablesEditor" x-on:open-modal.window="handleOpen($event)" class="space-y-4">
        <template x-for="(row, index) in rows" :key="index">
            <div class="flex flex-wrap items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 dark:border-white/10">
                <input
                    type="text"
                    x-model="row.name"
                    placeholder="nama_variabel"
                    class="w-48 rounded-lg border-gray-300 bg-white text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-800 dark:text-white"
                />

                <span
                    class="text-xs"
                    x-bind:class="row.formula != null ? 'text-success-600 dark:text-success-400' : 'text-gray-400'"
                    x-text="row.formula != null ? 'Rumus tersimpan' : 'Belum ada rumus'"
                ></span>

                <div class="ms-auto flex items-center gap-1">
                    <x-filament::button size="sm" color="gray" icon="heroicon-m-pencil-square" x-on:click="editFormula(index)">
                        Edit rumus
                    </x-filament::button>
                    <x-filament::icon-button
                        icon="heroicon-o-trash"
                        color="danger"
                        size="sm"
                        label="Hapus variabel"
                        x-on:click="removeRow(index)"
                    />
                </div>
            </div>
        </template>

        <p x-show="rows.length === 0" class="text-sm text-gray-500 dark:text-gray-400">
            Belum ada variabel. Tambahkan variabel lalu susun rumusnya dengan blok.
        </p>

        <x-filament::button color="gray" outlined icon="heroicon-m-plus" x-on:click="addRow()">
            Tambah variabel
        </x-filament::button>

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

        {{-- Kanvas blok untuk rumus variabel yang sedang diedit --}}
        <div x-show="editingIndex !== null" x-cloak class="space-y-3">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                Rumus untuk <span class="font-semibold" x-text="rows[editingIndex]?.name || '(tanpa nama)'"></span>
            </p>

            <div wire:ignore>
                <div
                    x-ref="workspace"
                    class="h-[50vh] w-full overflow-hidden rounded-xl border border-gray-200 dark:border-white/10"
                ></div>
            </div>

            <div class="flex items-center justify-end gap-2">
                <x-filament::button color="gray" x-on:click="cancelFormula()">Batal edit rumus</x-filament::button>
                <x-filament::button color="info" icon="heroicon-o-check" x-on:click="applyFormula()">
                    Terapkan rumus
                </x-filament::button>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 border-t border-gray-100 pt-4 dark:border-white/10">
            <x-filament::button color="gray" x-on:click="$dispatch('close-modal', { id: 'builder-variables' })">
                Batal
            </x-filament::button>
            <x-filament::button icon="heroicon-o-check" x-on:click="saveAll()">
                Simpan semua
            </x-filament::button>
        </div>
    </div>
</x-filament::modal>
