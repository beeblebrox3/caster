<?php

namespace Beeblebrox3\Caster\Rules;


use Exception;
use PHPUnit\Framework\TestCase;

class LpadRuleTest extends TestCase
{
    /** @var LpadRule */
    private $object;

    public function setUp()
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

    /**
     * @expectedException Exception
     */
    public function testShouldThrowExceptionWithoutLength()
    {
        $this->object->handle('str');
    }

    /**
     * @expectedException Exception
     */
    public function testShouldThrowExceptionWithoutStr()
    {
        $this->object->handle('str', 2);
    }
}