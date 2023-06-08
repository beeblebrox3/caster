<?php

namespace Beeblebrox3\Caster\Exceptions;

use Exception;

class RuleNotFound extends Exception
{
    public function __construct(protected string $ruleName, protected string $tried = '')
    {
        parent::__construct("Rule $ruleName not found (tried $tried)");
    }
}
