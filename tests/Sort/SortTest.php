<?php

namespace Mitirrli\Buildable\Tests\Sort;

use Mitirrli\Buildable\Buildable;
use Mitirrli\Buildable\Exception\NotExistException;
use Mitirrli\Buildable\Tests\Constant\TestSort;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    use Buildable;

    /**
     * test NotExistException.
     *
     * @throws NotExistException
     */
    public function testSort()
    {
        //Test 1. test string key
        $key = 'create_time';
        $test1 = $this->param(TestSort::TEST_SORT1)->sort('create_time')->result();

        self::assertIsArray($test1);
        self::assertArrayHasKey('sort', $test1);
        self::assertEquals($key.' '.TestSort::TEST_SORT1[$key], $test1['sort']);

        //Test 2. rename sort
        $key = 'create_time';
        $rename_key = 'rename';
        $test2 = $this->initial([])->param(TestSort::TEST_SORT1)->sort('create_time', $rename_key)->result();

        self::assertIsArray($test2);
        self::assertArrayHasKey($rename_key, $test2);
        self::assertEquals($key.' '.TestSort::TEST_SORT1[$key], $test2[$rename_key]);

        //Test 3. rename array sort
        $key = 'create_time';
        $sql_key = 'create';
        $rename_key = 'rename';
        $test3 = $this->initial([])->param(TestSort::TEST_SORT1)->sort([$key, $sql_key], $rename_key)->result();

        self::assertIsArray($test3);
        self::assertArrayHasKey($rename_key, $test3);
        self::assertEquals($sql_key.' '.TestSort::TEST_SORT1[$key], $test3[$rename_key]);

        //Test 4. multi sort.
        $key2 = 'update_time';
        $test4 = $this->initial([])->param(TestSort::TEST_SORT2)->sort($key)->sort($key2)->result();

        self::assertIsArray($test4);
        self::assertArrayHasKey('sort', $test4);
        self::assertEquals($key2.' '.TestSort::TEST_SORT2[$key2], $test4['sort']);

        //Test 5. rename multi sort.
        $test5 = $this->initial([])->param(TestSort::TEST_SORT2)->sort($key, 'num1')->sort($key2, 'num2')->result();
        self::assertIsArray($test5);
        self::assertArrayHasKey('num1', $test5);
        self::assertEquals($key2.' '.TestSort::TEST_SORT2[$key2], $test5['num2']);
        self::assertEquals($key.' '.TestSort::TEST_SORT2[$key], $test5['num1']);
        self::assertArrayHasKey('num2', $test5);
    }
}
