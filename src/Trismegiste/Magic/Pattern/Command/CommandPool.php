<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Command;

/**
 * CommandPool is a concrete commands pool
 */
class CommandPool implements Invoker
{

    protected $pool = array();

    /**
     * @inheritDoc
     */
    public function attach($name, \Closure $cls)
    {
        $this->pool[$name] = $cls;
        
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function execute($name)
    {
        $args = func_get_args();
        array_shift($args);

        if (!array_key_exists($name, $this->pool)) {
            throw new \RuntimeException("$name is not declared");
        }

        return call_user_func_array($this->pool[$name], $args);
    }

    /**
     * Magic call to alias execute()
     * 
     * @param string $name format is ^exec(.+)$
     * @param mixed $arguments
     * 
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (preg_match('#^exec(.+)$#', $name, $extract)) {

            array_unshift($arguments, $extract[1]);

            return call_user_func_array(array($this, 'execute'), $arguments);
        }

        trigger_error('Call to undefined method ' . __CLASS__ . "::$name", E_USER_ERROR);
    }

}