<?php

namespace App\Models;

use Database\Factories\OptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bentuk kolom `scores` per tipe soal:
 * - single/multiple/likert: {"D": 2, "I": 1} — poin per kode dimensi (skala "sum").
 * - most_least: {"most": {"D": 1}, "least": {"S": 1}} — poin saat dipilih most/least.
 */
class Option extends Model
{
    /** @use HasFactory<OptionFactory> */
    use HasFactory;

    protected $fillable = [
        'question_id',
        'label',
        'sort',
        'scores',
        'image_path',
    ];

    /**
     * @return array{scores: string}
     */
    protected function casts(): array
    {
        return [
            'scores' => 'array',
        ];
    }

    /** @return BelongsTo<Question, $this> */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
