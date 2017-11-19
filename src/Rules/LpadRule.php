<?php

namespace Beeblebrox3\Caster\Rules;

class LpadRule extends StringPadRule
{
    protected function getType(): string
    {
        return STR_PAD_LEFT;
    }
}