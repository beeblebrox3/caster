<?php

namespace rules;

use Beeblebrox3\Caster\Rules\BoolRule;
use PHPUnit\Framework\TestCase;

class BoolRuleTest extends TestCase
{
    private BoolRule $object;

    protected function setUp(): void
    {
        $this->object = new BoolRule();
    }

    public function testShouldConvertToTrue()
    {
        $values = [
            1,
            true,
            '1',
        ];

        foreach ($values as $value) {
            $this->assertTrue($this->object->handle($value));
        }
    }

    public function testShouldConvertToFalse()
    {
        $values = [
            '',
            0,
            '0',
            false
        ];

        foreach ($values as $value) {
            $this->assertFalse($this->object->handle($value));
        }
    }

    public function testShouldHandleNulls()
    {
        // the second parameter allows to specify how to handle empty values ('' and null).
        // If enabled, will return null. Else, will return false

        $this->assertFalse($this->object->handle(null));
        $this->assertFalse($this->object->handle(''));

        $this->assertNull($this->object->handle(null, true));
        $this->assertNull($this->object->handle('', true));
    }
}
