<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Command;

/**
 * Invoker is a contract for a pool of commands ( = closures)
 * 
 * Replace the invoker in the Command Design Pattern
 */
interface Invoker
{

    /**
     * Attaches a command to this pool
     * 
     * @param string $name the name of the command
     * @param \Closure $cls the closure to call
     * 
     * @return $this for fluent interface
     */
    public function attach($name, \Closure $cls);

    /**
     * Executes a command by its name (+ other parameters)
     * 
     * @param string $name command name
     * @param mixed ... other parameters to pass to closure
     * 
     * @return mixed
     */
    public function execute($name);
}