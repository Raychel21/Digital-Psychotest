<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscAnswer extends Model
{
    protected $guarded = [];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function question()
    {
        return $this->belongsTo(DiscQuestion::class, 'disc_question_id');
    }

    public function mostItem()
    {
        return $this->belongsTo(DiscItem::class, 'most_item_id');
    }

    public function leastItem()
    {
        return $this->belongsTo(DiscItem::class, 'least_item_id');
    }
}
