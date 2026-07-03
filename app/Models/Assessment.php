<?php

namespace App\Models;

use App\Enums\AssessmentStatus;
use Database\Factories\AssessmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    /** @use HasFactory<AssessmentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'instructions',
        'status',
        'settings',
        'logic',
        'created_by',
    ];

    /**
     * @return array{status: string, settings: string}
     */
    protected function casts(): array
    {
        return [
            'status' => AssessmentStatus::class,
            'settings' => 'array',
            'logic' => 'array',
        ];
    }

    /** @return HasMany<Dimension, $this> */
    public function dimensions(): HasMany
    {
        return $this->hasMany(Dimension::class)->orderBy('sort');
    }

    /** @return HasMany<Question, $this> */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('sort');
    }

    /** @return HasMany<Interpretation, $this> */
    public function interpretations(): HasMany
    {
        return $this->hasMany(Interpretation::class);
    }

    /** @return HasMany<Attempt, $this> */
    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }

    /** @return HasMany<Invitation, $this> */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /** @return BelongsTo<User, $this> */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Skala yang dipakai untuk menentukan dimensi dominan pada hasil.
     */
    public function primaryScale(): string
    {
        return $this->settings['primary_scale'] ?? 'sum';
    }

    public function isPublished(): bool
    {
        return $this->status === AssessmentStatus::Published;
    }

    /**
     * Batas waktu pengerjaan dalam menit; null = tanpa batas.
     */
    public function timeLimitMinutes(): ?int
    {
        $limit = $this->settings['time_limit_minutes'] ?? null;

        return is_numeric($limit) && (int) $limit > 0 ? (int) $limit : null;
    }
}
