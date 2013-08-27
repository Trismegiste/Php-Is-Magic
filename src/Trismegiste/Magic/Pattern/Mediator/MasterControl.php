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
            // check the callable
            if (!is_callable(array($obj, $method))) {
                throw new \InvalidArgumentException(get_class($obj) . "::$method does not exist");
            }
            $this->subscribe($obj, $method, $alias);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function exportAll($obj)
    {
        $refl = new \ReflectionClass($obj);
        foreach ($refl->getMethods(\ReflectionMethod::IS_PUBLIC) as $meth) {
            $name = $meth->getName();
            if (!preg_match('#^__#', $name) && !$meth->isStatic()) {
                $this->subscribe($obj, $name);
            }
        }

        return $this;
    }

    protected function subscribe($obj, $method, $alias = null)
    {
        // default aliasing
        if (!is_string($alias)) {
            $alias = $method;
        }
        // check alias collision
        if (array_key_exists($alias, $this->colleagueMethod)) {
            $found = $this->colleagueMethod[$alias];
            throw new \InvalidArgumentException("$alias is already aliased to "
            . get_class($found[0]) . "::{$found[1]}");
        }
        $this->colleagueMethod[$alias] = array($obj, $method);
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