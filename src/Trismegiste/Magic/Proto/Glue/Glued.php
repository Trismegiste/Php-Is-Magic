<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Glue;

/**
 * Glued is a aggregation of methods javascript-like capability
 */
trait Glued
{

    private $method = array();

    public function __set($name, \Closure $func)
    {
        $this->method[$name] = \Closure::bind($func, $this, __CLASS__);
    }

    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->method)) {
            return call_user_func_array($this->method[$name], $arguments);
        } else {
            trigger_error('Call to undefined method ' . get_called_class() . "::$name", E_USER_ERROR);
        }
    }

}