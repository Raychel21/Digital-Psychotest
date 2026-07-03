<?php

namespace App\Models;

use Database\Factories\DimensionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dimension extends Model
{
    /** @use HasFactory<DimensionFactory> */
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'code',
        'name',
        'description',
        'sort',
    ];

    /** @return BelongsTo<Assessment, $this> */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /** @return HasMany<Norm, $this> */
    public function norms(): HasMany
    {
        return $this->hasMany(Norm::class);
    }

    /** @return HasMany<Interpretation, $this> */
    public function interpretations(): HasMany
    {
        return $this->hasMany(Interpretation::class);
    }
}
