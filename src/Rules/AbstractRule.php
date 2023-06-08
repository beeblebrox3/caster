<?php

namespace Beeblebrox3\Caster\Rules;

use Beeblebrox3\Caster\Contracts\Rule;

abstract class AbstractRule implements Rule
{
    protected function getArg(array $args, int $id)
    {
        return array_key_exists($id, $args) ? $args[$id] : null;
    }
}
