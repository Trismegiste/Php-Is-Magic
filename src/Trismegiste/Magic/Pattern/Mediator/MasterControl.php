<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Mediator;

/**
 * MasterControl is a dynamic mediator
 */
class MasterControl implements Mediator, Subscriber
{

    protected $colleagueMethod = array();

    public function __construct()
    {
        
    }

    /**
     * {@inheritDoc}
     * 
     * @throws \LogicException if $obj is not an object
     * @throws \InvalidArgumentException if name collision for methods
     */
    public function export($obj, array $methodList)
    {
        if (!is_object($obj)) {
            throw new \LogicException('1st parameter is not an object');
        }

        foreach ($methodList as $method) {
            if (array_key_exists($method, $this->colleagueMethod)) {
                throw new \InvalidArgumentException("$method is already subscribed by "
                . get_class($this->colleagueMethod[$method]));
            }
            $this->colleagueMethod[$method] = $obj;
        }

        return $this;
    }

    /**
     * Magic call for handle invocation on colleague
     */
    public function __call($name, $arguments)
    {
        if (!array_key_exists($name, $this->colleagueMethod)) {
            throw new \BadMethodCallException("Method $name is not subscribed");
        }

        $target = $this->colleagueMethod[$name];

        return call_user_func_array(array($target, $name), $arguments);
    }

}