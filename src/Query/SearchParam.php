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
     * @param int    $fuzzy
     *
     * @return string
     */
    public static function getFuzzyParam(string $key, int $fuzzy): string
    {
        switch ($fuzzy) {
            case Constant::RIGHT:
                return $key.'%';

            case Constant::LEFT:
                return '%'.$key;

            case Constant::ALL:
                return '%'.$key.'%';
        }
    }
}
