<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Tests\Sort;

use Mitirrli\Buildable\Exception\NotExistException;
use Mitirrli\Buildable\Sortable;
use Mitirrli\Buildable\Tests\Constant\TestSort;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SortTest extends TestCase
{
    use Sortable;

    /**
     * test NotExistException.
     *
     * @throws NotExistException
     */
    public function testSort()
    {
        //Test 1. test string key
        $key = 'create_time';
        $test1 = $this->param(TestSort::TEST_SORT1)->sort('create_time')->order();

        self::assertIsString($test1);
        self::assertEquals($key.' '.TestSort::TEST_SORT1[$key], $test1);

        //Test 2. rename sort
        $key = 'create_time';
        $rename_key = 'rename';
        $test2 = $this->initial([])->param(TestSort::TEST_SORT1)->sort('create_time', $rename_key)->order($rename_key);

        self::assertIsString($test2);
        self::assertEquals($key.' '.TestSort::TEST_SORT1[$key], $test2);

        //Test 3. rename array sort
        $key = 'create_time';
        $sql_key = 'create';
        $rename_key = 'rename';
        $test3 = $this->initial([])->param(TestSort::TEST_SORT1)->sort([$key, $sql_key], $rename_key)->order($rename_key);

        self::assertIsString($test3);
        self::assertEquals($sql_key.' '.TestSort::TEST_SORT1[$key], $test3);

        //Test 4. multi sort.
        $key2 = 'update_time';
        $test4 = $this->initial([])->param(TestSort::TEST_SORT2)->sort($key)->sort($key2)->order();

        self::assertIsString($test4);
        self::assertEquals($key2.' '.TestSort::TEST_SORT2[$key2], $test4);

        //Test 5. rename multi sort.
        $test5 = $this->initial([])->param(TestSort::TEST_SORT2)->sort($key, 'num1')->sort($key2, 'num1')->order('num1');

        self::assertIsString($test5);
        self::assertEquals($key2.' '.TestSort::TEST_SORT2[$key2], $test5);
    }

    /**
     * test sort not exist.
     *
     * @throws NotExistException
     */
    public function testSortNotExist()
    {
        $key = 'create_time';
        $key2 = 'update_time';

        $this->expectException(NotExistException::class);
        $this->expectExceptionMessage('This key is not exist.');
        $this->expectExceptionCode(2);

        $this->initial([])->param(TestSort::TEST_SORT2)->sort($key, 'num1')->sort($key2, 'num1')->order('num2');
    }
}
