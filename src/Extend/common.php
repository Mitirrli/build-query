<?php

if (!function_exists('param_exist')) {
    function param_exist(string $var)
    {
        return (isset($var) && $var !== '') ? true : false;
    }
}
