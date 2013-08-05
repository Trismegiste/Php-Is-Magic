<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Strategy;

/**
 * StrategyImpl is an implementation of Strategy interface
 */
trait StrategyImpl
{

    private $strategyClosure;

    public function setStrategy(\Closure $callable)
    {
        $this->strategyClosure = $callable;
    }

    protected function callStrategy()
    {
        $args = func_get_args();
        if (is_null($this->strategyClosure)) {
            throw new \LogicException('Strategy is not set');
        }

        return call_user_func_array($this->strategyClosure, $args);
    }

}