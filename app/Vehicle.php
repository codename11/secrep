<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    
    protected $fillable = [
        'registration', 'sec_id', "workOrganization_id"
    ];

    public function deliveries(){
        return $this->belongsTo("App\Delivery",'vehicle_id');
    }

    public function user(){
        return $this->belongsTo("App\User", 'sec_id', "id");
    }

    public function type(){
        return $this->belongsTo("App\VehiclePivot", 'vehicle_type_id', "id");
    }

    public function workOrganization(){
        return $this->belongsTo("App\WorkOrganization", 'workOrganization_id', "id");
    }

}
