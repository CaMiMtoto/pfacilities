<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed|string|null shared_by
 * @property \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed position_id
 * @property mixed user_application_id
 */
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
