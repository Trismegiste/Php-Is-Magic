<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Mediator;

/**
 * Subscriber is a contract for subscribing to handle requests
 */
interface Subscriber
{

    /**
     * Subscribes an object and declares which methods can be accessed
     * 
     * @param object $obj
     * @param array $method a list a method name
     * 
     * @return $this for fluent interface
     */
    public function export($obj, array $method);
}