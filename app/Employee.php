<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function facility(){
        return $this->belongsTo(Facility::class);
    }
    public function position(){
        return $this->belongsTo(EmployeePosition::class,'position_id','id');
    }
}
