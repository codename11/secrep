<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrganization extends Model
{
    
    protected $table = 'work_organizations';
    protected $fillable = [
        'name', "sec_id"
    ];

    public function vehicles(){
        return $this->hasMany("App\Vehicle", 'workOrganization_id', "id");
    }

}
