<?php

namespace App\Actions\Participant;

use App\Enums\AttemptStatus;
use App\Models\Attempt;
use App\Models\Invitation;

/**
 * Membuat attempt baru (status berjalan) dari undangan yang sudah ditukarkan.
 */
class StartAttempt
{
    public function handle(Invitation $invitation): Attempt
    {
        return Attempt::query()->create([
            'assessment_id' => $invitation->assessment_id,
            'user_id' => $invitation->user_id,
            'invitation_id' => $invitation->id,
            'status' => AttemptStatus::InProgress,
            'current_index' => 0,
            'started_at' => now(),
        ]);
    }
}
