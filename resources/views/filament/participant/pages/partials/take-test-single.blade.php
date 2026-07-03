{{-- single_choice / likert: satu pilihan --}}
<div class="space-y-2" role="radiogroup">
    @foreach ($question->options as $option)
        <label
            class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:border-primary-400 hover:bg-primary-50 dark:border-gray-700 dark:hover:bg-primary-950"
        >
            <input
                type="radio"
                name="option_{{ $question->id }}"
                value="{{ $option->id }}"
                wire:model.live="state.option_id"
                class="h-4 w-4 shrink-0 border-gray-300 text-primary-600 focus:ring-primary-600"
            />

            @include('filament.participant.pages.partials.take-test-option-image', ['option' => $option])

            <span class="text-sm text-gray-900 dark:text-white">{{ $option->label }}</span>
        </label>
    @endforeach
</div>

@error('state.option_id')
    <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
@enderror
