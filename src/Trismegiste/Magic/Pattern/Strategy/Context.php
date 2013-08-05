<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Strategy;

/**
 * Context is a contract for a Context of Strategy Pattern
 */
interface Context
{

    /**
     * Injects strategy
     * 
     * @param \Closure $callable
     */
    public function setStrategy(\Closure $callable);
}