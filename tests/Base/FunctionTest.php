<?php

namespace Mitirrli\Buildable\Tests\Base;

use Mitirrli\Buildable\Buildable;
use Mitirrli\Buildable\Constant;
use PHPUnit\Framework\TestCase;

class FunctionTest extends TestCase
{
    use Buildable;

    /**
     * test static func get fuzzy param.
     */
    public function testGetFuzzyParam()
    {
        $key = 'a';

        self::assertEquals($this->getFuzzyParam($key, Constant::ALL), '%'.$key.'%');
        self::assertEquals($this->getFuzzyParam($key, Constant::LEFT), '%'.$key);
        self::assertEquals($this->getFuzzyParam($key, Constant::RIGHT), $key.'%');
    }
}
