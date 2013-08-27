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
     * @param array $method a list a method name (if a key is a string this will be an alias for the method)
     * 
     * @return self for fluent interface
     */
    public function export($obj, array $method);

    /**
     * Subscribes all object's non-static non-magic public methods without aliasing
     * (not recommanded except in early stage of development)
     * 
     * @param object $obj the object
     * 
     * @return self for fluent interface
     */
    public function exportAll($obj);
}