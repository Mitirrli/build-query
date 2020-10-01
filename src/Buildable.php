<?php

declare(strict_types=1);

namespace Mitirrli\Buildable;

use Mitirrli\Buildable\Query\SearchTrait;

trait Buildable
{
    use SearchTrait;

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
     * @param array|string $key can be array or string
     * @param int $fuzzy fuzzy search
     *
     * @return $this
     *
     * @throws Exception\NotExistException
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
            ['LIKE', $this->getFuzzyParam($this->params[$key], $fuzzy)]
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
     * @param string $key name of key
     * @param array $value array of value
     *
     * @return $this
     *
     * <pre>
     * $this->betweenKey('created_at', ['start' => 'create', 'end' => 'end']);
     * </pre>
     */
    public function betweenKey(string $key, array $value = ['start' => 0, 'end' => 100])
    {
        $this->init[$key] = ['<=', $this->params[$value['end'] ?? 0] ?? 0];

        if (array_key_exists('start', $value) && array_key_exists('end', $value)) {
            $this->init[$key] = ['BETWEEN', [$this->params[$value['start']], $this->params[$value['end']]]];
        } elseif (array_key_exists('start', $value)) {
            $this->init[$key] = ['>=', $this->params[$value['start']]];
        }

        return $this;
    }

    /**
     * before one key.
     *
     * @param string $key name of key
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
     * @param string $key name of key
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
