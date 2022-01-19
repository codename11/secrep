<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    
    protected $fillable = [
        'registration', 'sec_id', "workOrganization_id"
    ];

    public function user(){
        return $this->belongsTo("App\User", 'sec_id', "id");
    }

    public function complements(){
        return $this->hasMany("App\Complement", 'vehicle_id', "id");
    }

    public function type(){
        return $this->belongsTo("App\VehiclePivot", 'vehicle_type_id', "id");
    }

    public function workOrganization(){
        return $this->belongsTo("App\WorkOrganization", 'workOrganization_id', "id");
    }

    public function deliveries(){
        return $this->belongsToMany("App\Delivery", "App\Complement", "vehicle_id", "delivery_id");
    }

}
