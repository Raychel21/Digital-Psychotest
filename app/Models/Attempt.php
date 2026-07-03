<?php

namespace App\Models;

use App\Enums\AttemptStatus;
use Database\Factories\AttemptFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Attempt extends Model
{
    /** @use HasFactory<AttemptFactory> */
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'user_id',
        'invitation_id',
        'status',
        'current_index',
        'started_at',
        'completed_at',
    ];

    /**
     * @return array{status: string, current_index: string, started_at: string, completed_at: string}
     */
    protected function casts(): array
    {
        return [
            'status' => AttemptStatus::class,
            'current_index' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<Assessment, $this> */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Invitation, $this> */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    /** @return HasMany<Answer, $this> */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /** @return HasOne<TestResult, $this> */
    public function result(): HasOne
    {
        return $this->hasOne(TestResult::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === AttemptStatus::Completed;
    }

    /**
     * Batas akhir pengerjaan (started_at + batas waktu asesmen); null = tanpa batas.
     */
    public function expiresAt(): ?Carbon
    {
        $limitMinutes = $this->assessment?->timeLimitMinutes();

        if ($limitMinutes === null || $this->started_at === null) {
            return null;
        }

        return $this->started_at->clone()->addMinutes($limitMinutes);
    }

    /**
     * Apakah batas waktu pengerjaan attempt ini sudah terlewati.
     */
    public function isExpired(): bool
    {
        return $this->expiresAt()?->isPast() ?? false;
    }
}
