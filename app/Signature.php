<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{

    protected $appends = ['signature_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSignatureUrlAttribute()
    {
        return asset('storage/files/signatures' . $this->attributes['file_name']);
    }
}
