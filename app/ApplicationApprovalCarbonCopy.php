<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationApprovalCarbonCopy extends Model
{
    protected $guarded=[];
    public function applicationApproval()
    {
        return $this->belongsTo(ApplicationApproval::class);
    }
}
