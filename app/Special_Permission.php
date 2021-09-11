<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Special_Permission extends Model
{
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

}
