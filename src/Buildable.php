<?php

declare(strict_types=1);

namespace Mitirrli\Buildable;

trait Buildable
{
    use Sortable;

    /**
     * assign the value.
     *
     * @param array|string $key   can be array or string
     * @param int          $fuzzy fuzzy search
     *
     * @throws Exception\NotExistException
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->key('x');
     * $this->key(['x', 'y']);            //rename x as y
     * $this->key('x', Constant::RIGHT);  //right fuzzy search
     * $this->key('x', Constant::ALL);    //all fuzzy search
     * </pre>
     */
    public function key($key, int $fuzzy = Constant::NONE)
    {
        $result = $this->renameKey($key);

        if (param_exist($this->params, $result['key'])) {
            $this->init[$result['name']]
                = $fuzzy ?
                ['LIKE', $this->getFuzzyParam($this->params[$result['key']], $fuzzy)]
                : $this->params[$result['key']];
        }

        return $this;
    }

    /**
     * in some keys.
     *
     * @param array|string $key name of key
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->inKey('x');
     * $this->inKey(['x', 'y']);   //rename x as y
     * </pre>
     */
    public function inKey($key)
    {
        $result = $this->renameKey($key);

        if (param_exist($this->params, $result['key'])) {
            if (is_string($key = $this->params[$result['key']])) {
                $key = explode(',', $key);
            }
            $this->init[$result['name']] = ['IN', array_unique($key)];
        }

        return $this;
    }

    /**
     * Between two keys.
     *
     * @param string $key   name of key
     * @param array  $value array of value
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->betweenKey('created_at', ['start' => 'create', 'end' => 'end']);
     * </pre>
     */
    public function betweenKey(string $key, array $value)
    {
        if (array_key_exists('start', $value) && array_key_exists('end', $value)
            && param_exist($this->params, $value['end']) && param_exist($this->params, $value['start'])
        ) {
            $this->init[$key] = ['BETWEEN', [$this->params[$value['start']], $this->params[$value['end']]]];
        } elseif (array_key_exists('start', $value) && param_exist($this->params, $value['start'])) {
            $this->init[$key] = ['>=', $this->params[$value['start']]];
        } elseif (array_key_exists('end', $value) && param_exist($this->params, $value['end'])) {
            $this->init[$key] = ['<=', $this->params[$value['end']]];
        }

        return $this;
    }

    /**
     * before one key.
     *
     * @param array|string $key name of key
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->beforeKey('x')
     * $this->beforeKey(['x', 'y']);   //rename x as y
     * </pre>
     */
    public function beforeKey($key)
    {
        $result = $this->renameKey($key);

        if (param_exist($this->params, $key = $result['key'])) {
            $this->init[$result['name']] = ['<', $this->params[$key]];
        }

        return $this;
    }

    /**
     * after one key.
     *
     * @param array|string $key name of key
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->afterKey('x')
     * $this->afterKey(['x', 'y']);   //rename x as y
     * </pre>
     */
    public function afterKey($key)
    {
        $result = $this->renameKey($key);

        if (param_exist($this->params, $key = $result['key'])) {
            $this->init[$result['name']] = ['>', $this->params[$key]];
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
}
