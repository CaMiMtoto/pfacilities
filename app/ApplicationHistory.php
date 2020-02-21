<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationHistory extends Model
{
    public function application()
    {
        return $this->belongsTo(UserApplication::class, 'user_application_id', 'id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'shared_to_position_id', 'id');
    }

    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'shared_by', 'id');
    }
}
