<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed|null user_id
 * @property mixed|string|string[] document_file
 * @property mixed document_id
 * @property mixed user_application_id
 * @property mixed application_type_id
 * @property mixed facility_id
 */
class FacilityDocument extends Model
{
    public function document(){ return $this->belongsTo(Document::class);}
    public function facility(){ return $this->belongsTo(Facility::class);}
}
