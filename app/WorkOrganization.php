<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrganization extends Model
{
    use SoftDeletes;
    
    protected $table = 'work_organizations';
    protected $fillable = [
        'name', "sec_id"
    ];

    public function vehicles(){
        return $this->hasMany("App\Vehicle", 'workOrganization_id', "id");
    }

    public function employees(){
        return $this->hasMany("App\Employee",'work_org_id');
    }

    public function user(){
        return $this->belongsTo("App\User",'sec_id');
    }

}
