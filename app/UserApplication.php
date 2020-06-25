<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property string status
 * @property mixed id
 * @property mixed facility
 * @property mixed comment
 * @property mixed|string application_id
 * @property mixed facility_id
 * @property mixed application_type_id
 * @property int|mixed|null user_id
 */
class UserApplication extends Model
{
    public function applicationType()
    {
        return $this->belongsTo(ApplicationType::class);
    }

    public function approvalLetter()
    {
        return $this->hasOne(ApplicationApproval::class);
    }

    public function FacilityDocuments()
    {
        return $this->hasMany(FacilityDocument::class);
    }

    public function applicationShares()
    {
        return $this->hasMany(ApplicationShare::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHandler()
    {
        if ($this->status == 'verified') {
            return 'Inspection';
        } else if ($this->status == 'received') {
            return 'Verifier';
        } else if ($this->status == 'inspected') {
            return 'Approval';
        } else if ($this->status == 'approved') {
            return 'Certification';
        }
        return 'Verifier';
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function progress()
    {
        return ApplicationShare::with('position')->where('user_application_id', $this->id)->first();
    }

    public function shared()
    {
        $app = ApplicationShare::with('position')->where([
            ['user_application_id', $this->id],
            ['shared_by', Auth::id()],
        ])->first();

        if ($app) return true;
        return false;
    }

    public function certificates()
    {
        return $this->hasMany(CertificatePicking::class);
    }

    public function history()
    {
        return $this->hasMany(ApplicationHistory::class, 'user_application_id', 'id');
    }

    public function sharedToMe()
    {
        $app = $this->applicationShares()->where([
            ['user_application_id', '=', $this->id],
            ['position_id', '=', \auth()->user()->position_id]
        ])->orderByDesc('id')->limit('1')->first();
        return $app ? true : false;
    }

    public function lastSharedTo()
    {
        return $this->applicationShares()->where([
            ['user_application_id', '=', $this->id]
        ])->orderByDesc('id')->limit('1')->first();
    }
}
