<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->belongsTo("App\User", "user_id", "id");
    }
    
}
