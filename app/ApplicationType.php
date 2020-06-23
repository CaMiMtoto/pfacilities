<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array|mixed|string|null name
 * @property mixed id
 */
class ApplicationType extends Model
{


    public function applicationTypeDocuments(){
        return $this->hasMany(ApplicationTypeDocument::class);
    }
}
