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
        return match($fuzzy) {
            Constant::RIGHT => $key.'%',
            Constant::LEFT  => '%'.$key,
            Constant::ALL => '%'.$key.'%',
            default => throw new NotExistException(
                'This value is not exist.', 1
            )
        };
    }

    /**
     * rename key for what you want.
     *
     * @param array|string $key
     *
     * @return array
     */
    public function renameKey($key)
    {
        $name = is_array($key) ? $key[1] : $key;
        $key = is_array($key) ? $key[0] : $key;

        return compact('name', 'key');
    }
}
