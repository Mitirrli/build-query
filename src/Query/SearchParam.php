<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Query;

use Mitirrli\Buildable\Constant;

final class SearchParam
{
    /**
     * generate different params.
     *
     * @param string $key
     * @param int $fuzzy
     *
     * @return string
     */
    public static function getParam(string $key, int $fuzzy): string
    {
        switch ($fuzzy) {
            case Constant::RIGHT:
                return $key. '%';

            case Constant::LEFT:
                return '%'. $key;

            default:
                return '%'. $key. '%';
        }
    }
}
