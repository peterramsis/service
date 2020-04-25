<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class usernameOrPassword implements Rule
{
    /**
     * Create a new rule instance.
     */

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return request()->validate([
              $attribute => ['required', 'email', 'regex:/(.*)@(gmail|yahoo|hotmail|ymail|outlook|[a-zA-z])\.com/i'],
            ], ['email.regex' => 'The email format is invaild']);
        } elseif (preg_match('/^[a-zA-Z-_0-9]*$/', $value)) {
            return request()->validate([
               $attribute => 'required|alpha_dash|min:4|max:32',
            ], ['username' => 'the username is invaild']);
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
