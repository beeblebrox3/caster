<?php

namespace Beeblebrox3\Caster\Rules;

class IntegerRule implements IRule
{
    public function handle($value, ...$args)
    {
        if (is_null($value)) {
            return null;
        }
        return intval($value);
    }
}