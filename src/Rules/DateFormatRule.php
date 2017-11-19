<?php

namespace Beeblebrox3\Caster\Rules;

use DateTime;
use Exception;
use InvalidArgumentException;

class DateFormatRule extends AbstractRule
{
    private $defaultFormat = 'Y-m-d H:i:s';

    /**
     * @param mixed $value
     * @param array ...$args
     * @return string
     * @throws InvalidArgumentException
     */
    public function handle($value, ...$args)
    {
        $format = $this->getArg($args, 0);
        $inputFormat = $this->getArg($args, 1);
        $inputFormat = $inputFormat ?: $this->defaultFormat;

        if (null === $format) {
            throw new InvalidArgumentException("Format must be provided");
        }

        $date = DateTime::createFromFormat($inputFormat, $value);
        if (!$date) {
            return null;
        }

        return $date->format($format);
    }
}