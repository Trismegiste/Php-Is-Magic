<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Dispatcher;

/**
 * Dispatcher is an abstract dispatcher of event with magic call
 */
abstract class Dispatcher
{

    protected $listener = array();

    /**
     * Subscribe an object to all methods which can receive 
     * an Event (or a subclass of Event)
     * 
     * @param object $listener
     */
    abstract public function addListener($listener);

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