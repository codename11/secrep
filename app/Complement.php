<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complement extends Model
{
    protected $table = 'complement';
    protected $fillable = [
        'delivery_id', 
        'vehicle_id',
    ];

    public function vehicles(){
        return $this->belongsTo("App\Vehicle", 'vehicle_id');
    }

}
