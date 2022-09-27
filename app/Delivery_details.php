<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery_details extends Model
{
    use SoftDeletes;
    
    protected $table = 'delivery_details';
    protected $fillable = [
        'delivery_id', 
        'delivery_note',
        "sec_id"
    ];

    public function delivery(){
        return $this->belongsTo("App\Delivery",'delivery_id');
    }

    public function enteredBy(){
        return $this->belongsTo("App\User",'sec_id');
    }
    
}
