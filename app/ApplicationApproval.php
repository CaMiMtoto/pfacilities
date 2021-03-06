<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationApproval extends Model
{
    protected $guarded = [];

    public function carbonCopies()
    {
        return $this->hasMany(ApplicationApprovalCarbonCopy::class);
    }

    public function userApplication()
    {
        return $this->belongsTo(UserApplication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
