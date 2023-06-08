<?php

namespace rules;

use Beeblebrox3\Caster\Rules\RpadRule;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RpadRuleTest extends TestCase
{
    private RpadRule $object;

    protected function setUp(): void
    {
        $this->object = new RpadRule();
    }

    public function testShouldPad()
    {
        $input = [
            ['a', 3, 'x', 'axx'],
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
}
