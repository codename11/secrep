<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiclePivot extends Model
{
    use SoftDeletes;
    
    protected $table = 'vehicle_pivot';
    protected $fillable = [
        'name'
    ];

    public function vehicles(){
        return $this->hasMany("App\Vehicle", "vehicle_type_id", "id");
    }

}
