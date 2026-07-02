<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscItem extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(DiscQuestion::class, 'disc_question_id');
    }
}
