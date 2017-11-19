<?php

namespace src;

use Beeblebrox3\Caster\Caster;
use Beeblebrox3\Caster\Exceptions\RuleNotFoundException;
use Exception;
use PHPUnit\Framework\TestCase;

class CasterTest extends TestCase
{
    /** @var Caster */
    protected $object;

    public function setUp()
    {
        $this->object = new Caster();
    }

    public function testCast()
    {
        // test rules parsing and nested arrays
        $types = [
            'bool.true' => 'bool',
            'bool.false' => 'bool',
            'bool.null' => 'bool',
            'date_format.ptbr' => 'date_format:d/m/Y H:i:s',
            'date_format.only_month' => 'date_format:m',
            'date_format.custom_input' => 'date_format:m,m-Y/d',
            'float.without_round' => 'float',
            'float.with_round' => 'float:2',
            'integer' => 'integer',
            'lpad' => 'lpad:3,x',
            'rpad' => 'rpad:3,x',
            'string.crop.3' => 'string:3',
            'string.crop.2' => 'string:2',
        ];

        $input = [
            'bool' => [
                'true' => 1,
                'false' => 0,
                'null' => null
            ],
            'date_format' => [
                'ptbr' => '2017-01-11 00:00:00',
                'only_month' => '2017-01-11 00:00:00',
                'custom_input' => '01-2017/11',
            ],
            'float' => [
                'with_round' => '2.499',
                'without_round' => 2.499
            ],
            'integer' => '10',
            'lpad' => 'ab',
            'rpad' => 'ab',
            'string' => [
                'crop' => [
                    3 => 'abcd',
                    2 => 'abcd',
                ]
            ]
        ];

        $expected = [
            'bool' => [
                'true' => true,
                'false' => false,
                'null' => null
            ],
            'date_format' => [
                'ptbr' => '11/01/2017 00:00:00',
                'only_month' => '01',
                'custom_input' => '01',
            ],
            'float' => [
                'with_round' => 2.50,
                'without_round' => 2.499
            ],
            'integer' => 10,
            'lpad' => 'xab',
            'rpad' => 'abx',
            'string' => [
                'crop' => [
                    3 => 'abc',
                    2 => 'ab',
                ]
            ]
        ];

        $this->assertEquals($expected, $this->object->cast($types, $input));
    }

    /**
     * @expectedException Exception
     */
    public function testShouldThrowExceptionWithInvalidRule()
    {
        $this->object->cast(['a' => 'InvalidRule'], ['a' => 1]);
    }
}