<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Strategy;

/**
 * Strategy is a contract for a Context of Strategy Pattern
 */
interface Strategy
{

    /**
     * Injects strategy
     * 
     * @param \Closure $callable
     */
    public function setStrategy(\Closure $callable);
}