<?php

namespace App\Actions\Builder;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Validasi & simpan gambar builder (soal/opsi) ke disk `public`.
 */
class StoreBuilderImage
{
    /**
     * @throws ValidationException jika berkas bukan gambar atau melebihi 2 MB.
     */
    public function handle(UploadedFile $file, string $directory): string
    {
        Validator::make(
            ['image' => $file],
            ['image' => ['image', 'max:2048']],
            ['image' => 'Berkas harus berupa gambar dengan ukuran maksimal 2 MB.'],
        )->validate();

        $path = $file->store($directory, 'public');

        if (! is_string($path)) {
            throw ValidationException::withMessages(['image' => 'Gambar gagal disimpan. Coba lagi.']);
        }

        return $path;
    }
}
