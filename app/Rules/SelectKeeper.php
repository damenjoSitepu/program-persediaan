<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class SelectKeeper implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if ($value == 0) {
            $fail("Choose The Correct {$attribute} Select Option!");
        }
    }
}
