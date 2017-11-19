<?php

namespace Beeblebrox3\Caster\Rules;

use InvalidArgumentException;

abstract class StringPadRule extends AbstractRule
{
    abstract protected function getType() : string;

    protected function getArgs(array $args) : array
    {
        $length = $this->getArg($args, 0);
        $data = $this->getArg($args, 1);

        if ($length === null) {
            throw new InvalidArgumentException("Length cannot be null");
        }

        if (!is_numeric($length)) {
            throw new InvalidArgumentException("Length must be numeric");
        }

        if ($data === null) {
            throw new InvalidArgumentException("Data cannot be null");
        }

        return [$length, $data, $this->getType()];
    }

    public function handle($value, ...$args)
    {
        list($length, $data, $type) = $this->getArgs($args);

        $res = strval($value);

        return str_pad($res, $length, $data, $type);
    }
}
