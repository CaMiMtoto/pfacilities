<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string document
 * @property string recommendations
 * @property string comment
 * @property Carbon date
 * @property int|null user_id
 * @property mixed facility_id
 * @property mixed purpose
 * @property mixed visitor
 */
class FacilityVisit extends Model
{
    public function facility(){
        return $this->belongsTo(Facility::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
