<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Tests\Constant;

abstract class TestSort
{
    public const TEST_SORT1 = [
        'create_time' => 'desc',
    ];

    public const TEST_SORT2 = [
        'create_time' => 'desc',
        'update_time' => 'asc',
        'sort' => 'asc',
    ];
}
