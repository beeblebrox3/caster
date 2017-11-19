<?php

namespace Beeblebrox3\Caster\Exceptions;

use Exception;

class RuleNotFound extends Exception {
    protected $ruleName;
    protected $tried;

    public function __construct(string $ruleName, string $tried = '')
    {
        $this->ruleName = $ruleName;
        $this->tried = $tried;

        parent::__construct("Rule $ruleName not found (tried $tried)");
    }
}
