<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utility extends Model
{
    use SoftDeletes;
    
    protected $table = "utilities";
    protected $fillable = [
        "per_page"
    ];
}
