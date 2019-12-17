<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityDocumentRenewing extends Model
{
    protected $casts = ['issued_at' => 'datetime', 'expires_at' => 'datetime'];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
