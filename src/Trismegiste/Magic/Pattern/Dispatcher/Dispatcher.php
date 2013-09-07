<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Dispatcher;

/**
 * Dispatcher is a dispatcher of event with closures and magic call
 */
class Dispatcher
{

    protected $listener = array();

    /**
     * Subscribe an object to all methods which can receive 
     * an Event (or a subclass of Event)
     * 
     * @param object $listener
     */
    public function addListener($listener)
    {
        $refl = new \ReflectionClass($listener);
        foreach ($refl->getMethods() as $meth) {
            $methName = $meth->getName();
            if (!$meth->isStatic() &&
                    !preg_match('#^__.+#', $methName) &&
                    $meth->getNumberOfParameters() == 1) {
                // get type-hint
                $classParam = $meth->getParameters()[0]->getClass();
                // check type-hint
                if (!is_null($classParam) &&
                        $classParam->implementsInterface(__NAMESPACE__ . '\Event')) {
                    // invoke
                    $this->listener[$methName][] = $listener;
                }
            }
        }
    }

    /**
     * Dispatch an event to all listeners. The matching is between the
     * event name string and the method name.
     * 
     * @param string $methodName
     * 
     * @param \Trismegiste\Magic\Pattern\Dispatcher\Event $event
     */
    public function dispatch($methodName, Event $event)
    {
        if (array_key_exists($methodName, $this->listener)) {
            foreach ($this->listener[$methodName] as $obj) {
                call_user_func(array($obj, $methodName), $event);
            }
        }
    }

    /**
     * Magic call to replace 
     * dispatch('doSomething', $event) by dispatchDoSomething($event)
     * 
     * @return void
     */
    public function __call($methName, array $args)
    {
        $extract = array();
        if (preg_match('#^dispatch([A-Z].+)$#', $methName, $extract) &&
                (1 == count($args))) {
            // check argument
            if (!($args[0] instanceof Event)) {
                throw new \InvalidArgumentException(gettype($args) . " is not an Event");
            }
            // invokation
            $this->dispatch(lcfirst($extract[1]), $args[0]);
        } else {
            trigger_error('Call to undefined method ' . __CLASS__ . '::' . $methName, E_USER_ERROR);
        }
    }

}