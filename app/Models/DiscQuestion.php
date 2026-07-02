<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscQuestion extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(DiscItem::class);
    }

    public function answers()
    {
        return $this->hasMany(DiscAnswer::class);
    }
}
