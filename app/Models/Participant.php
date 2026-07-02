<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function answers()
    {
        return $this->hasMany(DiscAnswer::class);
    }
}
