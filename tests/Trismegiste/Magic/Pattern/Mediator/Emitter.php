<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Mediator;

use Trismegiste\Magic\Pattern\Mediator\ColleagueImpl;

class Emitter
{

    use ColleagueImpl;

    public function execute()
    {
        return $this->mediator->handleRequest();
    }

    public function executeAlias()
    {
        return $this->mediator->handle();
    }

}