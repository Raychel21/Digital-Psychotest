<?php

namespace App\Actions\Participant;

use App\Models\Attempt;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Menukarkan kode undangan menjadi attempt baru untuk peserta.
 */
class RedeemInvitation
{
    public function __construct(private readonly StartAttempt $startAttempt) {}

    /**
     * @throws ValidationException jika kode tidak valid, sudah dipakai, kedaluwarsa,
     *                             milik akun lain, atau asesmennya belum dipublikasikan.
     */
    public function handle(User $user, string $code): Attempt
    {
        $invitation = Invitation::query()
            ->where('code', trim($code))
            ->with('assessment')
            ->first();

        if (! $invitation instanceof Invitation) {
            throw ValidationException::withMessages([
                'code' => 'Kode undangan tidak ditemukan. Periksa kembali kode Anda.',
            ]);
        }

        if ($invitation->user_id !== null && $invitation->user_id !== $user->id) {
            throw ValidationException::withMessages([
                'code' => 'Kode undangan ini terdaftar untuk akun lain.',
            ]);
        }

        if (! $invitation->isUsable()) {
            throw ValidationException::withMessages([
                'code' => 'Kode undangan sudah digunakan atau telah kedaluwarsa.',
            ]);
        }

        if (! $invitation->assessment?->isPublished()) {
            throw ValidationException::withMessages([
                'code' => 'Asesmen untuk kode ini belum dipublikasikan. Hubungi penyelenggara.',
            ]);
        }

        return DB::transaction(function () use ($invitation, $user): Attempt {
            $invitation->forceFill([
                'user_id' => $user->id,
                'used_at' => now(),
            ])->save();

            return $this->startAttempt->handle($invitation);
        });
    }
}
