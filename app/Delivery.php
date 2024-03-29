<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;
    
    protected $table = 'deliveries';
    protected $fillable = [
        'load_place', 
        'unload_place',
        "comment",
        "time_in",
        "time_out",
        "operator_id",
        "sec_id"
    ];

    public function operator(){
        return $this->belongsTo("App\Employee",'operator_id');
    }

    public function enteredBy(){
        return $this->belongsTo("App\User",'sec_id');
    }

    public function complement(){
        return $this->hasMany("App\Complement", 'delivery_id');
    }

    public function employees(){
        return $this->belongsTo("App\Employee", 'operator_id', "id");
    }

    public function deliveryDetails(){
        return $this->hasMany("App\Delivery_details", 'delivery_id', "id");
    }

}
