<?php

namespace Beeblebrox3\Caster\Rules;

use PHPUnit\Framework\TestCase;

class StringRuleTest extends TestCase
{
    /** @var StringRule */
    private $object;

    public function setUp()
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