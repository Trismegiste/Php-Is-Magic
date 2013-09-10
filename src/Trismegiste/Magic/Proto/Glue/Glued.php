<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Glue;

/**
 * Glued is an aggregation of methods javascript-like capability.
 * 
 * Note : for experimental use only !
 */
trait Glued
{

    private $method = array();

    public function __set($name, $func)
    {
        if ($func instanceof \Closure) {
            // I could use __CLASS__ instead of get_called_class() but
            // that means that private properties could be accessed from subclasses
            // of a class which uses this trait. It's a design choice.
            $this->method[$name] = \Closure::bind($func, $this, get_called_class());
        } else {
            // simple injection of public data
            $this->$name = $func;
        }
    }

    public function __call($name, $arguments)
    {
        if (!array_key_exists($name, $this->method)) {
            trigger_error('Call to undefined method ' . get_called_class() . "::$name", E_USER_ERROR);
        }

        return call_user_func_array($this->method[$name], $arguments);
    }

}