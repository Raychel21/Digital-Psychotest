<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $guarded = [];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
