<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Tests;

class MultiInKey
{
    public function a(array $data)
    {
        return array_map(function ($key) {
            return $key * $key;
        }, $data);
    }

    public function b(array $data)
    {
        return array_map(function ($key) {
            return 2 * $key - 2;
        }, $data);
    }
}
