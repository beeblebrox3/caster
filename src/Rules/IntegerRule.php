<?php

namespace Beeblebrox3\Caster\Rules;

use Beeblebrox3\Caster\Contracts\Rule;

class IntegerRule implements Rule
{
    public function handle($value, ...$args): int | null
    {
        if (is_null($value)) {
            return null;
        }
        return intval($value);
    }
}
