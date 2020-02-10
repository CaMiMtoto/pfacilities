<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationShare extends Model
{
    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'shared_by', 'id');
    }

    public function userApplication()
    {
        return $this->belongsTo(UserApplication::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
