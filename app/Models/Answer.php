<?php

namespace App\Models;

use Database\Factories\AnswerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bentuk kolom `payload` per tipe soal:
 * - single_choice/likert: {"option_id": 5}
 * - multiple_choice: {"option_ids": [1, 2]}
 * - most_least: {"most_option_id": 1, "least_option_id": 3}
 * - text: {"text": "..."}
 */
class Answer extends Model
{
    /** @use HasFactory<AnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'payload',
    ];

    /**
     * @return array{payload: string}
     */
    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    /** @return BelongsTo<Attempt, $this> */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }

    /** @return BelongsTo<Question, $this> */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
