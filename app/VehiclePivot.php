<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehiclePivot extends Model
{

    protected $table = 'vehicle_pivot';
    protected $fillable = [
        'name'
    ];

}
