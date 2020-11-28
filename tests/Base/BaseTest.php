<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Tests\Base;

use Mitirrli\Buildable\Buildable;
use Mitirrli\Buildable\Tests\Constant\TestData;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class BaseTest extends TestCase
{
    use Buildable;

    /**
     * test function initial.
     */
    public function testInitial()
    {
        array_map(function ($value) {
            $object = $this->initial($value);

            self::assertEquals($object->result(), $value);
        }, TestData::TEST_DATA1);
    }

    /**
     * test function param.
     */
    public function testParam()
    {
        array_map(function ($value) {
            $object = $this->param($value);

            $property = new \ReflectionProperty($object, 'params');
            $property->setAccessible(true);

            self::assertEquals($value, $property->getValue($object));
        }, TestData::TEST_DATA1);
    }

    /**
     * test function result.
     */
    public function testResult()
    {
        $keys = array_keys(TestData::TEST_DATA2);

        array_map(function ($value) {
            self::assertArrayHasKey($value, $this->param(TestData::TEST_DATA2)->key($value)->result());
        }, $keys);
    }
}
