<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistrictReport extends Model
{
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function doneBy()
    {
        return $this->belongsTo(User::class, 'done_by', 'id');
    }
}
