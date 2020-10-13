<?php

declare(strict_types=1);

namespace Mitirrli\Buildable\Query;

trait BaseTrait
{
    use SearchTrait;

    private $init = [];

    private $params = [];

    private $order = [];

    /**
     * get user params.
     *
     * @param array $params
     *
     * @return $this
     *
     * @example
     * <pre>
     * $this->param(['x' => 'y']);
     * </pre>
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
     *
     * @example
     * <pre>
     * $this->initial(['x' => 'y']);
     * </pre>
     */
    public function initial(array $init)
    {
        $this->init = $init;

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