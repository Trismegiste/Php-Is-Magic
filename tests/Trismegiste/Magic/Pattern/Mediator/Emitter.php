<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Mediator;

use Trismegiste\Magic\Pattern\Mediator\Mediator;

class Emitter
{

    protected $mediator;

    public function __construct(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }

    public function execute()
    {
        return $this->mediator->handleRequest();
    }

    public function executeAlias()
    {
        return $this->mediator->handle();
    }

}