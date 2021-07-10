<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrganization extends Model
{
    
    protected $table = 'work_organizations';
    protected $fillable = [
        'name', "sec_id"
    ];

    public function vehicles(){
        return $this->hasMany("App\Vehicle", 'workOrganization_id', "id");
    }

    public function type(){
        return $this->belongsToMany("App\VehiclePivot", "App\Vehicle", 'vehicle_type_id', "id");
    }

}
