<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Tests\Exception;

use Mitirrli\Buildable\Buildable;
use Mitirrli\Buildable\Exception\NotExistException;
use Mitirrli\Buildable\Tests\Constant\TestData;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ExceptionTest extends TestCase
{
    use Buildable;

    /**
     * test NotExistException.
     *
     * @throws NotExistException
     */
    public function testNotExistException()
    {
        //Test 1. test exception
        $this->expectException(NotExistException::class);
        $this->expectExceptionMessage('This value is not exist.');
        $this->expectExceptionCode(1);

        //Test 2. key not exist
        $key = 'test';
        $this->initial([])->param(TestData::TEST_DATA2)->key($key, 4)->result();
    }
}
