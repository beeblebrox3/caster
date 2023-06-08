<?php

namespace rules;

use Beeblebrox3\Caster\Rules\FloatRule;
use PHPUnit\Framework\TestCase;

class FloatruleTest extends TestCase
{
    private FloatRule $object;

    protected function setUp(): void
    {
        $this->object = new FloatRule();
    }

    public function testShouldConvertToFloat()
    {
        $values = [
            ['0.00', 0.00],
            ['0.098', 0.098],
            ['1.10', 1.10],
            [1, 1.0],
            ['0', 0],
            ['', 0]
        ];

        foreach ($values as $input) {
            $this->assertEquals($input[1], $this->object->handle($input[1]));
        }
    }

    public function testShouldConvertAndRound()
    {
        $this->assertEquals(
            2.5,
            $this->object->handle('2.45', 1)
        );

        $this->assertEquals(
            2.4,
            $this->object->handle('2.45', 1, PHP_ROUND_HALF_DOWN)
        );
    }

    public function testShouldReturnNull()
    {
        $this->assertNull($this->object->handle(null));
    }
}
