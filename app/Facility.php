<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed sector
 * @property mixed id
 */
class Facility extends Model
{
    protected $appends = ['data'];
    protected $casts = ['license_issued_at' => 'datetime', 'license_expires_at' => 'datetime'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function getDataAttribute()
    {
        return District::with('province')->where('id', $this->sector->district->id)->first();
    }

    public function facilityServices()
    {
        return $this->hasMany(FacilityService::class);
    }

    public function facilityVisits()
    {
        return $this->hasMany(FacilityVisit::class);
    }

    public function facilityDocuments()
    {
        return $this->hasMany(FacilityDocument::class);
    }

    public function facilityDocumentsRenews()
    {
        return $this->hasMany(FacilityDocumentRenewing::class);
    }

    public function userApplications()
    {
        return $this->hasMany(UserApplication::class);
    }

}
