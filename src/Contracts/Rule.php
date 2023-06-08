<?php

namespace Beeblebrox3\Caster\Contracts;

interface Rule
{
    public function handle(mixed $value, ...$args);
}
