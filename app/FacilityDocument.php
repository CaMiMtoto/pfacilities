<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityDocument extends Model
{
    public function document(){ return $this->belongsTo(Document::class);}
    public function facility(){ return $this->belongsTo(Facility::class);}
}
