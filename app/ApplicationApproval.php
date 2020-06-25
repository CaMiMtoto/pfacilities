<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationApproval extends Model
{
    protected $guarded=[];
    public function carbonCopies()
    {
        return $this->hasMany(ApplicationApprovalCarbonCopy::class);
    }
}
