<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApplicationComment extends Model
{
    public function userApplication(){
        return $this->belongsTo(UserApplication::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
