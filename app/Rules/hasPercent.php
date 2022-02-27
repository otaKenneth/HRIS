<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class hasPercent implements Rule
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
        return (strpos($value, "%") > 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This field needs a %.';
    }
}
