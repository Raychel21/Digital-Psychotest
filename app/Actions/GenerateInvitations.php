<?php

namespace App\Actions;

use App\Models\Assessment;
use App\Models\Invitation;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GenerateInvitations
{
    /**
     * Create a batch of invitations with unique random codes for an assessment.
     *
     * @return Collection<int, Invitation>
     */
    public function handle(Assessment $assessment, int $count, ?CarbonInterface $expiresAt = null): Collection
    {
        return $this->uniqueCodes($count)->map(
            fn (string $code): Invitation => $assessment->invitations()->create([
                'code' => $code,
                'expires_at' => $expiresAt,
            ]),
        );
    }

    /**
     * @return Collection<int, string>
     */
    private function uniqueCodes(int $count): Collection
    {
        /** @var Collection<int, string> $codes */
        $codes = collect();

        while ($codes->count() < $count) {
            $candidates = Collection::times(
                $count - $codes->count(),
                fn (): string => Str::upper(Str::random(8)),
            )
                ->unique()
                ->reject(fn (string $code): bool => Invitation::query()->where('code', $code)->exists());

            $codes = $codes->merge($candidates)->unique()->values();
        }

        return $codes;
    }
}
