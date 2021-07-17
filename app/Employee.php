<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'lastName', 
        'firstName', 
        "work_org_id",
        "sec_id",
        "avatar"
    ];

    public function work_organization(){
        return $this->belongsTo("App\WorkOrganization",'work_org_id');
    }

    public function enteredBy(){
        return $this->belongsTo("App\User",'sec_id');
    }

    public function deliveries(){
        return $this->hasMany("App\Delivery",'operator_id');
    }

}
