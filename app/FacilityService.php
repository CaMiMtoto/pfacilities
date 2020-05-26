<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityService extends Model
{

    protected $guarded=[];
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
