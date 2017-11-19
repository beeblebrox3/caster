<?php

namespace Beeblebrox3\Caster\Rules;

interface IRule
{
    /**
     *
     * @param mixed $value
     * @param array|null ...$args
     * @return void
     */
    public function handle($value, ...$args);
}