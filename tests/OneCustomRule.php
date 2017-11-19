<?php

class OneCustomRule implements \Beeblebrox3\Caster\Rules\IRule
{
    public function handle($value, ...$args)
    {
        return 1;
    }
}
