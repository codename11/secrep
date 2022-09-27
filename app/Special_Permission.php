<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Special_Permission extends Model
{
    use SoftDeletes;
    
    protected $table = 'special_permissions';
    protected $fillable = [
        'permission_name', 
        'permission_description'
    ];


    public function user(){
        return $this->hasMany("App\User", 'special_permission_id', "id");
    }

    public function vehicles(){
        return $this->hasMany("App\Vehicle", 'special_permission_id', "id");
    }

    public function employees(){
        return $this->hasMany("App\Employee", 'special_permission_id', "id");
    }

}
