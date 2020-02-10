<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property string status
 */
class UserApplication extends Model
{
    public function applicationType()
    {
        return $this->belongsTo(ApplicationType::class);
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
}
