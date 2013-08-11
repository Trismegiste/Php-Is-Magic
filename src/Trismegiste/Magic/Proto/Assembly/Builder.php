<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Assembly;

/**
 * Builder is a contract for building mixin object
 */
interface Builder
{

    /**
     * Starts to build a new mixin
     * 
     * @return self
     */
    public function start();

    /**
     * Adds an Interface with its associated Trait
     * 
     * @param string $interfaceName
     * @param string $traitName (default = interface fqcn suffixed with 'Impl')
     * 
     * @return self
     */
    public function addPart($interfaceName, $traitName = null);

    /**
     * Gets the result
     * 
     * @param mixed ... any number of arguments for the constructor
     * 
     * @return object
     * 
     * @throws \RuntimeException if generation failed
     */
    public function getInstance();
}