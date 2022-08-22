<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Vehicle;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->hasOne("App\Role", "id", "role_id");
    }

    public function vehicles(){
        return $this->hasMany("App\Vehicle", "sec_id", "id");
    }

    public function deliveries(){
        return $this->hasMany("App\Delivery", "sec_id", "id");
    }

    public function complement(){
        return $this->hasMany("App\Complement", "sec_id", "id");
    }

    public function delivery_details(){
        return $this->hasMany("App\Delivery_details", "sec_id", "id");
    }

    public function special_permissions(){
        return $this->hasOne("App\Special_Permission", "sec_id", "id");
    }

    public function employees(){
        return $this->hasMany("App\Employee", "sec_id", "id");
    }

    public function utility(){
        return $this->hasOne("App\Utility", "user_id", "id");
    }
    
}
