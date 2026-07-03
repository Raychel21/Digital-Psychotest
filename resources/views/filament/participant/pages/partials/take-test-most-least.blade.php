{{-- most_least: pilih satu "Paling Menggambarkan" dan satu "Paling Tidak Menggambarkan" (harus berbeda) --}}
<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-200 text-left dark:border-gray-700">
                <th class="py-2 pe-4 font-medium text-gray-700 dark:text-gray-200">Pernyataan</th>
                <th class="px-4 py-2 text-center font-medium text-success-600 dark:text-success-400">
                    Paling Menggambarkan
                </th>
                <th class="px-4 py-2 text-center font-medium text-danger-600 dark:text-danger-400">
                    Paling Tidak Menggambarkan
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($question->options as $option)
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <td class="py-3 pe-4 text-gray-900 dark:text-white">
                        <div class="flex items-center gap-3">
                            @include('filament.participant.pages.partials.take-test-option-image', ['option' => $option])

                            <span>{{ $option->label }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input
                            type="radio"
                            name="most_{{ $question->id }}"
                            value="{{ $option->id }}"
                            wire:model.live="state.most_option_id"
                            class="h-4 w-4 border-gray-300 text-success-600 focus:ring-success-600"
                        />
                    </td>
                    <td class="px-4 py-3 text-center">
                        <input
                            type="radio"
                            name="least_{{ $question->id }}"
                            value="{{ $option->id }}"
                            wire:model.live="state.least_option_id"
                            class="h-4 w-4 border-gray-300 text-danger-600 focus:ring-danger-600"
                        />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@error('state.most_option_id')
    <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
@enderror

@error('state.least_option_id')
    <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
@enderror
