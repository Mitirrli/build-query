<?php

namespace Mitirrli\Buildable\Tests;

class MultiInKey
{
    public function a(array $data)
    {
        $result = array_map(fn ($key) => $key * $key, $data);

        return $result;
    }

    public function b(array $value)
    {
        $result = array_map(fn ($key) => $key + $key - 2, $value);

        return $result;
    }
}
