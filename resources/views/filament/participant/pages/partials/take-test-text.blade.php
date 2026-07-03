{{-- text: isian bebas (tidak dinilai) --}}
<div class="space-y-2">
    <textarea
        rows="5"
        wire:model.live.debounce.750ms="state.text"
        placeholder="Tulis jawaban Anda di sini..."
        class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
    ></textarea>

    <p class="text-xs text-gray-500 dark:text-gray-400">Jawaban tersimpan otomatis saat Anda berhenti mengetik.</p>
</div>

@error('state.text')
    <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
@enderror
