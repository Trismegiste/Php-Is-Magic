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

        foreach ($methodList as $alias => $method) {
            if (!is_string($alias)) {
                $alias = $method;
            }
            if (array_key_exists($alias, $this->colleagueMethod)) {
                throw new \InvalidArgumentException("$alias is already aliased to "
                . get_class($this->colleagueMethod[$alias][0]) . "::$method");
            }
            $this->colleagueMethod[$alias] = array($obj, $method);
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

        return call_user_func_array($this->colleagueMethod[$name], $arguments);
    }

}