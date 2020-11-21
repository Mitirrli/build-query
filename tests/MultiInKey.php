<?php

namespace Mitirrli\Buildable\Tests;

class MultiInKey
{
    public function a(array $data)
    {
        $result = array_map(function ($key) {
            return $key * $key;
        }, $data);

        return $result;
    }

    public function b(array $data)
    {
        $result = array_map(function ($key) {
            return 2 * $key - 2;
        }, $data);

        return $result;
    }
}
