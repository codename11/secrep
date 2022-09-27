<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complement extends Model
{
    use SoftDeletes;
    
    protected $table = 'complement';
    protected $fillable = [
        'delivery_id', 
        'vehicle_id',
    ];

    public function vehicles(){
        return $this->belongsTo("App\Vehicle", 'vehicle_id');
    }

    public function deliveries(){
        return $this->belongsTo("App\Delivery", 'delivery_id', "id");
    }

}
