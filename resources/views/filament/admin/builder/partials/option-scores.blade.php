@php
    use App\Enums\QuestionType;
    use App\Filament\Resources\Assessments\Support\OptionScoresMapper;

    $isMostLeast = $question->type === QuestionType::MostLeast;
    $selectClasses = 'w-full rounded-lg border-gray-300 bg-white py-1.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-800 dark:text-white';
@endphp

@if (empty($dimensionOptions))
    <p class="text-xs text-gray-500 dark:text-gray-400">
        Belum ada dimensi penilaian. Tambahkan dimensi lewat halaman edit alat tes agar skor opsi bisa diatur.
    </p>
@elseif ($isMostLeast)
    <div class="grid gap-3 sm:grid-cols-2">
        <label class="flex flex-col gap-1">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Dimensi "Paling" (most)</span>
            <select
                x-on:change="$wire.updateOption({{ $option->id }}, { most_code: $event.target.value })"
                class="{{ $selectClasses }}"
            >
                <option value="">— Tidak dinilai —</option>
                @foreach ($dimensionOptions as $code => $label)
                    <option value="{{ $code }}" @selected(OptionScoresMapper::mostCode($option->scores) === $code)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="flex flex-col gap-1">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Dimensi "Paling Tidak" (least)</span>
            <select
                x-on:change="$wire.updateOption({{ $option->id }}, { least_code: $event.target.value })"
                class="{{ $selectClasses }}"
            >
                <option value="">— Tidak dinilai —</option>
                @foreach ($dimensionOptions as $code => $label)
                    <option value="{{ $code }}" @selected(OptionScoresMapper::leastCode($option->scores) === $code)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </label>
    </div>
@else
    <div
        x-data="optionScores({ optionId: {{ $option->id }}, entries: @js(OptionScoresMapper::keyValueScores($option->scores)) })"
        class="flex flex-col gap-2"
    >
        <template x-for="(row, index) in rows" :key="index">
            <div class="flex items-center gap-2">
                <select x-model="row.code" x-on:change="save()" class="{{ $selectClasses }} flex-1">
                    <option value="">— Pilih dimensi —</option>
                    @foreach ($dimensionOptions as $code => $label)
                        <option value="{{ $code }}">{{ $label }}</option>
                    @endforeach
                </select>

                <input
                    type="number"
                    x-model="row.points"
                    x-on:change="save()"
                    placeholder="Poin"
                    class="w-20 rounded-lg border-gray-300 bg-white py-1.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-800 dark:text-white"
                />

                <button
                    type="button"
                    x-on:click="removeRow(index)"
                    class="p-1 text-gray-400 transition hover:text-danger-500"
                    title="Hapus baris skor"
                >
                    <x-filament::icon icon="heroicon-m-x-mark" class="h-4 w-4" />
                </button>
            </div>
        </template>

        <p x-show="rows.length === 0" class="text-xs text-gray-400 dark:text-gray-500">
            Opsi ini belum memberi skor ke dimensi mana pun.
        </p>

        <button
            type="button"
            x-on:click="addRow()"
            class="flex items-center gap-1.5 self-start text-xs font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400"
        >
            <x-filament::icon icon="heroicon-m-plus" class="h-3.5 w-3.5" />
            Tambah skor dimensi
        </button>
    </div>
@endif
