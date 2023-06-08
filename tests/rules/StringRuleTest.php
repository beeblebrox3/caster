<?php

namespace rules;

use Beeblebrox3\Caster\Rules\StringRule;
use PHPUnit\Framework\TestCase;

class StringRuleTest extends TestCase
{
    private StringRule $object;

    protected function setUp(): void
    {
        $this->object = new StringRule();
    }

    public function testShouldConvertToString()
    {
        $this->assertEquals('0.1', $this->object->handle(0.1));
        $this->assertEquals('22', $this->object->handle(22));
        $this->assertEquals('', $this->object->handle(''));
    }

    public function testShouldReturnNull()
    {
        $this->assertNull($this->object->handle(null));
    }

    public function testShouldCropString()
    {
        $this->assertEquals('abc', $this->object->handle('abcde', 3));
    }
}
