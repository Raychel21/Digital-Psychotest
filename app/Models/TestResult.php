<?php

namespace App\Models;

use Database\Factories\TestResultFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * raw_scores / norm_scores: {"sum": {"D": 10}, "most": {...}, "least": {...}, "change": {...}}
 * summary: {"primary_scale": "change", "primary_dimension": "D", "interpretations": [{...}]}
 */
class TestResult extends Model
{
    /** @use HasFactory<TestResultFactory> */
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'raw_scores',
        'norm_scores',
        'summary',
    ];

    /**
     * @return array{raw_scores: string, norm_scores: string, summary: string}
     */
    protected function casts(): array
    {
        return [
            'raw_scores' => 'array',
            'norm_scores' => 'array',
            'summary' => 'array',
        ];
    }

    /** @return BelongsTo<Attempt, $this> */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }
}
