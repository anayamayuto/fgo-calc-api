<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestDrop extends Model
{
    protected $fillable = ['quest_id', 'item_id', 'drop_rate'];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
