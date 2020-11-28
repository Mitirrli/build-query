<?php

declare(strict_types=1);

namespace Mitirrli\Buildable;

abstract class Constant
{
    /**
     * 精确查询.
     */
    public const NONE = 0;

    /**
     * 左右模糊查询.
     */
    public const ALL = 1;

    /**
     * 右模糊查询.
     */
    public const RIGHT = 2;

    /**
     * 左模糊查询.
     */
    public const LEFT = 3;
}
