<?php

declare(strict_types=1);

namespace Mitirrli\Buildable;

use Mitirrli\Buildable\Exception\NotExistException;
use Mitirrli\Buildable\Query\BaseTrait;

trait Sortable
{
    use BaseTrait;

    /**
     * add sort for mysql, front params like ['create_time' => 'asc'].
     * if multi sort, only select the last one.
     *
     * @param array|string $key  name of key
     * @param string       $name the key of init
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->sort('create_time');
     * $this->sort(['create', 'create_time']);
     * $this->sort('create_time', 'sort_2');
     * </pre>
     */
    public function sort($key, string $name = 'sort')
    {
        $result = $this->renameKey($key);

        if (param_exist($this->params, $result['key'])) {
            $this->init[$name] = $result['name'].' '.$this->params[$result['key']];
        }

        return $this;
    }

    /**
     * get order.
     *
     * @param string $name
     *
     * @throws NotExistException
     *
     * @return string
     */
    public function result(string $name = 'sort'): string
    {
        if (!array_key_exists($name, $this->init)) {
            throw new NotExistException('This key is not exist.', 2);
        }

        return $this->init[$name];
    }
}
