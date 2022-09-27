<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    
    protected $table = 'roles';
    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->belongsTo("App\User", "user_id", "id");
    }
    
}
