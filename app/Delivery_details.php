<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery_details extends Model
{
    protected $table = 'delivery_details';
    protected $fillable = [
        'delivery_id', 
        'delivery_note',
        "sec_id"
    ];
}
