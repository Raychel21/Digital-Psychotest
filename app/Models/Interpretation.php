<?php

namespace App\Models;

use App\Enums\NormScale;
use Database\Factories\InterpretationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interpretation extends Model
{
    /** @use HasFactory<InterpretationFactory> */
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'dimension_id',
        'scale',
        'min_value',
        'max_value',
        'title',
        'body',
    ];

    /**
     * @return array{scale: string, min_value: string, max_value: string}
     */
    protected function casts(): array
    {
        return [
            'scale' => NormScale::class,
            'min_value' => 'integer',
            'max_value' => 'integer',
        ];
    }

    /** @return BelongsTo<Assessment, $this> */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /** @return BelongsTo<Dimension, $this> */
    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }
}
