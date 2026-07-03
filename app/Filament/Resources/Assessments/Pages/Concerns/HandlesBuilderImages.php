<?php

namespace App\Filament\Resources\Assessments\Pages\Concerns;

use App\Actions\Builder\StoreBuilderImage;
use App\Actions\Builder\UpdateOption;
use App\Actions\Builder\UpdateQuestion;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Unggah gambar soal/opsi via Livewire: kunci `question-{id}` atau `option-{id}`.
 */
trait HandlesBuilderImages
{
    /** @var array<string, mixed> */
    public array $uploads = [];

    public function updatedUploads(mixed $file, string $key): void
    {
        if (! $file instanceof TemporaryUploadedFile) {
            return;
        }

        try {
            $this->storeUpload($file, $key);
            $this->markSaved();
        } catch (ValidationException $exception) {
            Notification::make()
                ->title('Gambar gagal diunggah')
                ->body(collect($exception->errors())->flatten()->implode(' '))
                ->danger()
                ->send();
        } finally {
            unset($this->uploads[$key]);
        }
    }

    public function removeQuestionImage(int $questionId): void
    {
        app(UpdateQuestion::class)->handle($this->question($questionId), ['image_path' => null]);
        $this->markSaved();
    }

    public function removeOptionImage(int $optionId): void
    {
        app(UpdateOption::class)->handle($this->option($optionId), ['image_path' => null]);
        $this->markSaved();
    }

    /**
     * @throws ValidationException
     */
    private function storeUpload(TemporaryUploadedFile $file, string $key): void
    {
        if (str_starts_with($key, 'question-')) {
            $path = app(StoreBuilderImage::class)->handle($file, 'builder/questions');
            app(UpdateQuestion::class)->handle(
                $this->question((int) substr($key, strlen('question-'))),
                ['image_path' => $path],
            );

            return;
        }

        if (str_starts_with($key, 'option-')) {
            $path = app(StoreBuilderImage::class)->handle($file, 'builder/options');
            app(UpdateOption::class)->handle(
                $this->option((int) substr($key, strlen('option-'))),
                ['image_path' => $path],
            );
        }
    }
}
