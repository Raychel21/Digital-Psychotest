{{-- Gambar opsi (jika ada) — dipakai lintas tipe soal --}}
@if (filled($option->image_path))
    <img
        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($option->image_path) }}"
        alt="{{ $option->label }}"
        draggable="false"
        loading="lazy"
        class="h-14 w-14 shrink-0 rounded-lg border border-gray-200 object-cover dark:border-gray-700"
    />
@endif
