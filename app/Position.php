<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
