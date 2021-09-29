<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Models implements Rule
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

        if($value === "Complement" || $value === "Delivery_details" || $value === "Delivery" || $value === "Employee" || $value === "Role" || $value === "Special_Permission" || $value === "User" || $value === "Vehicle" || $value === "VehiclePivot" || $value === "WorkOrganization"){
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
        return 'There isnt such model!';
    }
}
