<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function cells()
    {
        return $this->hasMany(Cell::class);
    }
}


