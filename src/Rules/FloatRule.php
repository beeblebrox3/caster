<?php

namespace Beeblebrox3\Caster\Rules;

class FloatRule extends AbstractRule
{
    public function handle($value, ...$args)
    {
        if (is_null($value)) {
            return null;
        }

        $precision = $this->getArg($args, 0);
        $mode = $this->getArg($args, 1);

        $res = floatval($value);

        if ($precision !== null && is_numeric($precision)) {
            $mode = $this->isAValidMode($mode) ? $mode : PHP_ROUND_HALF_UP;

            $res = round($res, intval($precision), $mode);
        }

        return $res;
    }

    final private function isAValidMode($mode) : bool
    {
        $availableModes = [
            PHP_ROUND_HALF_UP,
            PHP_ROUND_HALF_DOWN,
            PHP_ROUND_HALF_EVEN,
            PHP_ROUND_HALF_ODD
        ];

        return in_array($mode, $availableModes);
    }
}