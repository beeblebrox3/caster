<?php

namespace Beeblebrox3\Caster\Rules;

class RpadRule extends StringPadRule
{
    protected function getType(): string
    {
        return STR_PAD_RIGHT;
    }
}
