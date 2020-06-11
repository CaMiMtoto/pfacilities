<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed comment
 * @property mixed status
 * @property int|mixed|null shared_by
 * @property mixed shared_to_position_id
 */
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
