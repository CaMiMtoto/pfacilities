<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationApproval extends Model
{
    protected $guarded = [];
    protected $appends = ['signature_url'];

    public function getSignatureUrlAttribute()
    {
        return asset('storage/files/signatures' . $this->attributes['signature']);
    }

    public function carbonCopies()
    {
        return $this->hasMany(ApplicationApprovalCarbonCopy::class);
    }

    public function userApplication()
    {
        return $this->belongsTo(UserApplication::class);
    }
}
