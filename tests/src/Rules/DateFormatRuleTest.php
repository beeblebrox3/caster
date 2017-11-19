<?php

namespace Beeblebrox3\Caster\Rules;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DateFormatRuleTest extends TestCase
{
    /** @var DateFormatRule */
    private $object;

    public function setUp()
    {
        $this->object = new DateFormatRule();
    }

    public function testShouldFormatDate()
    {
        $date = '2017-01-11 00:01:02';
        $tests = [
            'Y-m-d H:i:s' => $date,
            'd/m/Y H:i:s' => '11/01/2017 00:01:02',
            'Y' => '2017',
        ];

        foreach ($tests as $format => $expected) {
            $this->assertEquals($expected, $this->object->handle($date, $format));
        }
    }

    public function testShouldReturnNullIfDateIsInvalid()
    {
        $this->assertNull($this->object->handle('invalid date', 'Y'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testShouldThrowExceptionWithoutFormat()
    {
        $this->object->handle('2017-01-01 00:00:00');
    }

    public function testShouldUseGivenFormatAsInputDate()
    {
        $this->assertEquals('12', $this->object->handle('20/12/2017', 'm', 'd/m/Y'));
    }
}