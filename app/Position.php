<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    public  static $PHF='Phf';
    public  static $DG='DG';

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
