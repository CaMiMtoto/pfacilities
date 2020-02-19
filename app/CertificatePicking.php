<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed picking_date
 * @property mixed user_application_id
 * @property array|string|null comment
 * @property array|string|null nid
 * @property array|string|null picked_by
 * @property \Illuminate\Support\Carbon picked_at
 */
class CertificatePicking extends Model
{
    protected $casts=['picking_date'=>'datetime'];

    public function userApplication(){
        return $this->belongsTo(UserApplication::class );
    }
}
