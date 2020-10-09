<?php

declare(strict_types=1);

namespace Mitirrli\Buildable;

use Mitirrli\Buildable\Query\SearchTrait;

trait Sortable
{
    use SearchTrait;

    /**
     * add sort for mysql, front params like ['create_time' => 'asc'].
     * if multi sort, only select the last one.
     *
     * @param $key
     * @param string $name
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
            $this->init[$name] = $result['name'] . ' ' . $this->params[$result['key']];
        }

        return $this;
    }
}