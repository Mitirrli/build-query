<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Tests\Constant;

abstract class TestData
{
    public const TEST_DATA1 = [
        ['test1' => 'data'],
        ['test2' => 'hello'],
        ['test3' => 'php'],
        ['test4' => '*qq#'],
    ];

    public const TEST_DATA2 = [
        'name' => 'hello',
        'language' => 'php',
        'test' => 'phpUnit',
    ];

    public const TEST_DATA3 = [
        'JS' => 'HTML',
        'PHP' => 'MYSQL',
        'C' => 'DLL',
    ];

    public const TEST_DATA4 = [
        'UN_UNIQUE_KEY' => [1, 1, 2, 3, 4],
    ];

    public const TEST_DATA5 = [
        'start' => 0,
        'end' => 22,
    ];

    public const TEST_DATA6 = [
        'UN_UNIQUE_KEY' => '1,1,2,3,4',
    ];

    public const TEST_DATA7 = [
        'key' => 1111,
    ];
}
