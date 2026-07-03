{{-- text: isian bebas (tidak dinilai) --}}
<div class="space-y-2">
    <x-filament::input.wrapper>
        <textarea
            rows="5"
            wire:model.live.debounce.750ms="state.text"
            placeholder="Tulis jawaban Anda di sini..."
            class="fi-input block w-full resize-y border-none bg-transparent px-3 py-2 text-sm text-gray-950 outline-none placeholder:text-gray-400 dark:text-white"
        ></textarea>
    </x-filament::input.wrapper>

    <p class="text-xs text-gray-500 dark:text-gray-400">Jawaban tersimpan otomatis saat Anda berhenti mengetik.</p>
</div>

@error('state.text')
    <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
@enderror
