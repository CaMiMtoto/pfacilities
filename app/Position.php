<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    public static $PHF = 'Phf';
    public static $DG = 'DG';
    public static $PS = 'Ps';
    public static $DGCPHS = 'DGCPHS';
    public static $DHPRU = 'DHPRU';
    public static $MINISTER = 'Minister';
    public static $MOS = 'MOS';
    public static $DGP= 'DGP';

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
