<?php

namespace rules;

use Beeblebrox3\Caster\Rules\LpadRule;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LpadRuleTest extends TestCase
{
    private LpadRule $object;

    protected function setUp(): void
    {
        $this->object = new LpadRule();
    }

    public function testShouldPad()
    {
        $input = [
            ['a', 3, 'x', 'xxa'],
            ['aaa', 3, 'x', 'aaa']
        ];

        foreach ($input as $data) {
            $this->assertEquals($data[3], $this->object->handle($data[0], $data[1], $data[2]));
        }
    }

    public function testShouldThrowExceptionWithoutLength()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->handle('str');
    }

    public function testShouldThrowExceptionWithoutStr()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->handle('str', 2);
    }

    public function testShouldGetExceptionWithInvalidLength()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->handle("", "a");
    }
}
