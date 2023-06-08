<?php

use Beeblebrox3\Caster\Contracts\Rule;

class OneCustomRule implements Rule
{
    public function handle($value, ...$args)
    {
        return 1;
    }
}
