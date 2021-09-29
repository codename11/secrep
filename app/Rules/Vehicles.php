<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Vehicles implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($value === "type" || $value === "workOrganization"){//Ovo su relationship-i iz modela.
            return true;
        }
        else{
            return false;
        }
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There  is no such type of vehicle!';
    }
}
