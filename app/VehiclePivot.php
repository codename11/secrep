<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehiclePivot extends Model
{

    protected $table = 'vehicle_pivot';
    protected $fillable = [
        'name'
    ];

    public function vehicles(){
        return $this->hasMany("App\Vehicle", "vehicle_type_id", "id");
    }

}
