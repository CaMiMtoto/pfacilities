<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    public function applicationTypeDocuments(){
        return $this->hasMany(ApplicationTypeDocument::class);
    }
}
