<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PhillipsData\Vin\Number;

class VIN implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new Number($value))->valid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.vin');
    }
}
