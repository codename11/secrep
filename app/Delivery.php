<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
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

}
