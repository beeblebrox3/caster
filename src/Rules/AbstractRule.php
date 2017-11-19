<?php

namespace Beeblebrox3\Caster\Rules;

abstract class AbstractRule implements IRule
{
    protected function getArg(array $args, int $id)
    {
        return array_key_exists($id, $args) ? $args[$id] : null;
    }
}