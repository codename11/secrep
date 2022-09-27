<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    
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
