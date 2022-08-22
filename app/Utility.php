<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    protected $table = "utilities";
    protected $fillable = [
        "per_page"
    ];
}
