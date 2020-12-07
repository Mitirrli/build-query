<?php

declare(strict_types=1);

if (! function_exists('param_exist')) {
    function param_exist(array $params, string $key)
    {
        return isset($params[$key])
            && $params[$key] !== ''
            && $params[$key] !== [];
    }
}
