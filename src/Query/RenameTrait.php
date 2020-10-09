<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Query;

trait RenameTrait
{
    public function rename($key)
    {
        $name = is_array($key) ? $key[1] : $key;
        $key = is_array($key) ? $key[0] : $key;

        return compact('name', 'key');
    }
}