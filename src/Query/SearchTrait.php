<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Query;

use Mitirrli\Buildable\Constant;
use Mitirrli\Buildable\Exception\NotExistException;

trait SearchTrait
{
    /**
     * generate different params.
     *
     * @param string $key
     * @param int    $fuzzy
     *
     * @throws NotExistException
     *
     * @return string
     */
    public function getFuzzyParam(string $key, int $fuzzy): string
    {
        switch ($fuzzy) {
            case Constant::RIGHT:
                return $key.'%';

            case Constant::LEFT:
                return '%'.$key;

            case Constant::ALL:
                return '%'.$key.'%';

            default:
                throw new NotExistException('This value is not exist.', 1);
        }
    }
}
