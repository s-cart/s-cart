<?php

namespace App\Pmo\Rules;

use Illuminate\Contracts\Validation\Rule;

class CaptchaRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */


    public $captchaMethod;

    public function __construct()
    {
        $this->captchaMethod = sc_captcha_method();
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
        if ($this->captchaMethod) {
            return $this->captchaMethod->validate($value);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->captchaMethod) {
            return $this->captchaMethod->msgError();
        } else {
            return 'Method captchat empty!';
        }
    }
}
