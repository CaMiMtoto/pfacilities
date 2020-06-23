<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed|null user_id
 * @property mixed application_type_id
 * @property mixed document_id
 */
class ApplicationTypeDocument extends Model
{
    public function document(){
        return $this->belongsTo(Document::class);

    }
}
