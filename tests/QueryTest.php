<?php

namespace Mitirrli\Buildable\Tests;

use Mitirrli\Buildable\Buildable;
use Mitirrli\Buildable\Constant;
use Mitirrli\Buildable\Tests\Constant\TestData;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    use Buildable;

    /**
     * test function key.
     */
    public function testKey()
    {
        //Test 1. accurate search
        $key = 'name';
        $object = $this->param(TestData::TEST_DATA2)->key($key);

        $property = new \ReflectionProperty($object, 'init');
        $property->setAccessible(true);
        self::assertEquals(TestData::TEST_DATA2[$key], $property->getValue($object)[$key]);

        //Test 2. right fuzzy search
        $key = 'language';
        $object = $this->param(TestData::TEST_DATA2)->key($key, Constant::RIGHT);

        $property = new \ReflectionProperty($object, 'init');
        $property->setAccessible(true);

        self::assertIsArray($test2 = $property->getValue($object)[$key]);
        self::assertEquals('LIKE', $test2[0]);
        self::assertEquals($test2[1], TestData::TEST_DATA2[$key].'%');

        //Test 3. all fuzzy search
        $key = 'test';
        $object = $this->param(TestData::TEST_DATA2)->key($key, Constant::ALL);

        $property = new \ReflectionProperty($object, 'init');
        $property->setAccessible(true);

        self::assertIsArray($test2 = $property->getValue($object)[$key]);
        self::assertEquals('LIKE', $test2[0]);
        self::assertEquals($test2[1], '%'.TestData::TEST_DATA2[$key].'%');

        $key = 'test';
        $new_key = 'new key';

        $result = $this->param(TestData::TEST_DATA2)->key([$key, $new_key])->result();

        self::assertIsArray($result);
        self::assertArrayHasKey($new_key, $result);

        //Test 4. key not exist
        $result = $this->initial([])->param(TestData::TEST_DATA2)->key('no_exist')->result();
        self::assertEquals([], $result);
        $result = $this->initial([])->param(TestData::TEST_DATA2)->key(['no_exist', 'exists'])->result();
        self::assertEquals([], $result);

        //Test 1. accurate search
        $key = 'JS';
        $new_key = 'NEW_JS';
        $object = $this->param(TestData::TEST_DATA3)->key([$key, $new_key]);

        $property = new \ReflectionProperty($object, 'init');
        $property->setAccessible(true);
        self::assertEquals(TestData::TEST_DATA3[$key], $property->getValue($object)[$new_key]);

        //Test 2. right fuzzy search
        $key = 'PHP';
        $new_key = 'NEW_PHP';
        $object = $this->param(TestData::TEST_DATA3)->key([$key, $new_key], Constant::RIGHT);

        $property = new \ReflectionProperty($object, 'init');
        $property->setAccessible(true);

        self::assertIsArray($test2 = $property->getValue($object)[$new_key]);
        self::assertEquals('LIKE', $test2[0]);
        self::assertEquals($test2[1], TestData::TEST_DATA3[$key].'%');

        //Test 2. right fuzzy search
        $key = 'C';
        $new_key = 'NEW_C';
        $object = $this->param(TestData::TEST_DATA3)->key([$key, $new_key], Constant::ALL);

        $property = new \ReflectionProperty($object, 'init');
        $property->setAccessible(true);

        self::assertIsArray($test2 = $property->getValue($object)[$new_key]);
        self::assertEquals('LIKE', $test2[0]);
        self::assertEquals($test2[1], '%'.TestData::TEST_DATA3[$key].'%');
    }

    /**
     * test function inKey.
     */
    public function testInKey()
    {
        //Test 1. Array
        $key = 'UN_UNIQUE_KEY';
        $result = $this->param(TestData::TEST_DATA4)->inKey($key)->result();
        self::assertEquals('IN', $result[$key][0]);
        self::assertIsArray($result);
        self::assertEquals($result[$key][1], array_unique(TestData::TEST_DATA4[$key]));

        //Test 2. Rename
        $key = 'UN_UNIQUE_KEY';
        $rename_key = 'RENAME';

        $result = $this->param(TestData::TEST_DATA4)->inKey([$key, $rename_key])->result();
        self::assertEquals('IN', $result[$rename_key][0]);
        self::assertIsArray($result);
        self::assertEquals($result[$rename_key][1], array_unique(TestData::TEST_DATA4[$key]));

        //Test 3. String
        $result = $this->param(TestData::TEST_DATA6)->inKey($key)->result();
        self::assertEquals('IN', $result[$key][0]);
        self::assertIsArray($result);
        self::assertEquals($result[$key][1], array_unique(explode(',', TestData::TEST_DATA6[$key])));

        //Test 4. Multi In
        unset($params);
        $params['front_param1'] = [1, 2, 3];
        $params['front_param2'] = [3, 6, 7];

        $result = $this->param($params)
            ->inKey(['front_param1', 'user'], [new MultiInKey(), 'a'])
            ->inKey(['front_param2', 'user'], [new MultiInKey(), 'b'])
            ->result();
        self::assertIsArray($result);
        self::assertArrayHasKey('user', $result);
        self::assertEquals($result['user'], ['IN', [4]]);
    }

    /**
     * test function betweenKey.
     */
    public function testBetweenKey()
    {
        //Test 1. Between
        $key = 'test1';
        $test1 = $this->param(TestData::TEST_DATA5)->betweenKey($key, ['start' => 'start', 'end' => 'end'])->result();

        self::assertIsArray($test1);
        self::assertEquals('BETWEEN', $test1[$key][0]);
        self::assertEquals($test1[$key][1], array_values(TestData::TEST_DATA5));

        //Test 2. <=
        $key = 'test2';
        $test2 = $this->param(TestData::TEST_DATA5)->betweenKey($key, ['end' => 'end'])->result();
        self::assertEquals('<=', $test2[$key][0]);
        self::assertEquals($test2[$key][1], TestData::TEST_DATA5['end']);

        //Test 3. >=
        $key = 'test3';
        $test3 = $this->param(TestData::TEST_DATA5)->betweenKey($key, ['start' => 'start'])->result();
        self::assertEquals('>=', $test3[$key][0]);
        self::assertEquals($test3[$key][1], TestData::TEST_DATA5['start']);
    }

    /**
     * test function beforeKey.
     */
    public function testBeforeKey()
    {
        //Test 1. One param
        $key = 'key';
        $test1 = $this->param(TestData::TEST_DATA7)->beforeKey($key)->result();

        self::assertIsArray($test1);
        self::assertEquals('<', $test1[$key][0]);
        self::assertEquals($test1[$key][1], TestData::TEST_DATA7[$key]);

        //Test 2. Two params
        $key = 'key';
        $test1 = $this->param(TestData::TEST_DATA7)->beforeKey([$key, 'result'])->result();

        self::assertIsArray($test1);
        self::assertEquals('<', $test1['result'][0]);
        self::assertEquals($test1['result'][1], TestData::TEST_DATA7[$key]);
    }

    /**
     * test function afterKey.
     */
    public function testAfterKey()
    {
        //Test 1. One param
        $key = 'key';
        $test1 = $this->param(TestData::TEST_DATA7)->afterKey($key)->result();

        self::assertIsArray($test1);
        self::assertEquals('>', $test1[$key][0]);
        self::assertEquals($test1[$key][1], TestData::TEST_DATA7[$key]);

        //Test 2. Two param
        $key = 'key';
        $test1 = $this->param(TestData::TEST_DATA7)->afterKey([$key, 'result'])->result();

        self::assertIsArray($test1);
        self::assertEquals('>', $test1['result'][0]);
        self::assertEquals($test1['result'][1], TestData::TEST_DATA7[$key]);
    }

    /**
     * test function unsetKey.
     */
    public function testUnsetKey()
    {
        //Test 1. One param
        $test1 = $this->initial(['a' => 1])->param(['b' => '2', 'c' => 3])->key('b')->result();
        self::assertArrayHasKey('a', $test1);
        self::assertArrayHasKey('b', $test1);

        $test1 = $this->unsetKey('a')->result();
        self::assertArrayNotHasKey('a', $test1);

        //Test 2. Two param
        $test2 = $this->initial(['a' => 1, 'd' => 4])->param(['b' => '2', 'c' => 3])->key('b')->result();
        self::assertArrayHasKey('a', $test2);
        self::assertArrayHasKey('b', $test2);
        self::assertArrayHasKey('d', $test2);

        $test2 = $this->unsetKey('a', 'b')->result();
        self::assertArrayNotHasKey('a', $test2);
        self::assertArrayNotHasKey('b', $test2);
        self::assertArrayHasKey('d', $test2);
    }
}
