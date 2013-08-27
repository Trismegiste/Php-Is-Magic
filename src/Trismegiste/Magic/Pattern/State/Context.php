<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\State;

/**
 * Context is a contract for a context with transition
 */
interface Context
{

    /**
     * Make a transition named $tName from the current state
     * 
     * @param string $tName transition's name
     */
    public function doTransition($tName);

    /**
     * Gets the current state
     * 
     * @return string
     */
    public function getState();
}