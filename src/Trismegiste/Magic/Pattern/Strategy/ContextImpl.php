<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Strategy;

/**
 * ContextImpl is an implementation of Context interface
 */
trait ContextImpl
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