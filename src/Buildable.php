<?php

declare(strict_types=1);

namespace Mitirrli\Buildable;

use Mitirrli\Buildable\Query\SearchParam;

trait Buildable
{
    private $init = [];

    private $params = [];

    /**
     * get user params.
     *
     * @param array $params
     *
     * @return $this
     */
    public function param(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * set default array.
     *
     * @param $init array default array
     *
     * @return $this
     */
    public function initial(array $init)
    {
        $this->init = $init;

        return $this;
    }

    /**
     * assign the value.
     *
     * @param array|string $key   can be array or string
     * @param int          $fuzzy fuzzy search
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->key('x');
     * $this->key(['x', 'y']);          //rename x as y
     * $this->key('x', Search::RIGHT);  //right fuzzy search
     * $this->key('x', Search::ALL);    //all fuzzy search
     * </pre>
     */
    public function key($key, int $fuzzy = Constant::NONE)
    {
        $name = is_array($key) ? $key[1] : $key;
        $key = is_array($key) ? $key[0] : $key;

        $this->init[$name]
            = $fuzzy ?
            ['LIKE', SearchParam::getParam($this->params[$key], $fuzzy)]
            : $this->params[$key];

        return $this;
    }

    /**
     * in some keys.
     *
     * @param string $key name of key
     *
     * @return $this
     */
    public function inKey(string $key)
    {
        if (isset($this->params[$key]) && !empty($this->params[$key])) {
            if (is_string($this->params[$key])) {
                $this->params[$key] = explode(',', $this->params[$key]);
            }
            $this->init[$key] = ['IN', array_unique($this->params[$key])];
        }

        return $this;
    }

    /**
     * Between two keys.
     *
     * @param string $key  name of key
     * @param array  $time array of time
     *
     * @return $this
     *
     * <pre>
     * $this->betweenKey('created_at', ['start' => 'create', 'end' => 'end']);
     * </pre>
     */
    public function betweenKey(string $key, array $time)
    {
        if (isset($this->params[$time['end']]) && isset($this->params[$time['start']])) {
            $this->init[$key] = ['BETWEEN', [$this->params[$time['start']], $this->params[$time['end']]]];
        }

        if (!isset($this->params[$time['end']]) && isset($this->params[$time['start']])) {
            $this->init[$key] = ['>=', $this->params[$time['start']]];
        }

        if (!isset($this->params[$time['start']]) && isset($this->params[$time['end']])) {
            $this->init[$key] = ['<=', $this->params[$time['end']]];
        }

        return $this;
    }

    /**
     * before one key.
     *
     * @param string      $key  name of key
     * @param string|null $name final name of the key
     *
     * @return $this
     */
    public function beforeKey(string $key, string $name = null)
    {
        if (isset($this->params[$key]) && !empty($this->params[$key])) {
            $this->init[$name ?? $key] = ['<', $this->params[$key]];
        }

        return $this;
    }

    /**
     * after one key.
     *
     * @param string      $key  name of key
     * @param string|null $name final name of the key
     *
     * @return $this
     */
    public function afterKey(string $key, string $name = null)
    {
        if (isset($this->params[$key]) && !empty($this->params[$key])) {
            $this->init[$name ?? $key] = ['>', $this->params[$key]];
        }

        return $this;
    }

    /**
     * unset some keys.
     *
     * @param mixed ...$key name of key
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->unsetKey('x', 'y');
     * </pre>
     */
    public function unsetKey(...$key)
    {
        array_map(function ($value) {
            unset($this->init[$value]);
        }, $key);

        return $this;
    }

    /**
     * get result.
     *
     * @return array
     */
    public function result(): array
    {
        return $this->init;
    }
}
