<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityLicense extends Model
{
    protected $casts=['signed_at'=>'datetime'];
    public function userApplication()
    {
        return $this->belongsTo(UserApplication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
