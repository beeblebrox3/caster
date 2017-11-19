<?php

namespace Beeblebrox3\Caster\Rules;

class StringRule extends AbstractRule
{
    /**
     * @param mixed $value
     * @param array ...$args
     * @return bool|string
     */
    public function handle($value, ...$args)
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
