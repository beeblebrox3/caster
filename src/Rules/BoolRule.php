<?php

namespace Beeblebrox3\Caster\Rules;

class BoolRule extends AbstractRule
{
    public function handle($value, ...$args): bool | null
    {
        $nullIfEmmpty = (bool) $this->getArg($args, 0);

        if ($nullIfEmmpty && in_array($value, [null, ''], true)) {
            return null;
        }

        return boolval($value);
    }
}
