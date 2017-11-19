<?php

namespace Beeblebrox3\Caster\Rules;

use PHPUnit\Framework\TestCase;

class IntegerRuleTest extends TestCase
{
    /** @var IntegerRule */
    private $object;

    public function setUp()
    {
        $this->object = new IntegerRule();
    }

    public function testShouldConvertToFloat()
    {
        $values = [
            ['0.00', 0],
            ['0.098', 0],
            ['1.10', 1],
            [1, 1],
            ['0', 0],
            ['', 0]
        ];

        foreach ($values as $input) {
            $this->assertEquals($input[1], $this->object->handle($input[1]));
        }
    }

    public function testShouldReturnNull()
    {
        $this->assertNull($this->object->handle(null));
    }
}