<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Mediator;

/**
 * ColleagueImpl is an implementation of default ctor for Colleague
 */
trait ColleagueImpl
{

    protected $mediator;

    public function __construct(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }

}