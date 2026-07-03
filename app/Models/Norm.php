<?php

namespace App\Models;

use App\Enums\NormScale;
use Database\Factories\NormFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Norm extends Model
{
    /** @use HasFactory<NormFactory> */
    use HasFactory;

    protected $fillable = [
        'dimension_id',
        'scale',
        'raw_min',
        'raw_max',
        'value',
    ];

    /**
     * @return array{scale: string, raw_min: string, raw_max: string, value: string}
     */
    protected function casts(): array
    {
        return [
            'scale' => NormScale::class,
            'raw_min' => 'integer',
            'raw_max' => 'integer',
            'value' => 'integer',
        ];
    }

    /** @return BelongsTo<Dimension, $this> */
    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }
}
