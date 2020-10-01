<?php

declare(strict_types=1);

namespace Mitirrli\Buildable;

abstract class Constant
{
    /**
     * 精确查询.
     */
    const NONE = 0;

    /**
     * 左右模糊查询.
     */
    const ALL = 1;

    /**
     * 右模糊查询.
     */
    const RIGHT = 2;

    /**
     * 左模糊查询.
     */
    const LEFT = 3;
}
