<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function  facility(){
        return $this->belongsTo(Facility::class);
    }
}
