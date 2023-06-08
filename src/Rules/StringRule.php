<?php

namespace Beeblebrox3\Caster\Rules;

class StringRule extends AbstractRule
{
    public function handle($value, ...$args): string | null
    {
        if (is_null($value)) {
            return null;
        }

        $length = $this->getArg($args, 0);

        $res = strval($value);
        if (is_numeric($length)) {
            $res = substr($res, 0, $length);
        }

        return $res;
    }
}
