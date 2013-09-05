<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Dispatcher;

use Trismegiste\Magic\Pattern\Dispatcher\Event;

interface Component
{

    public function doSomething(Event $e);

    public function nameCollision(Event $e);
}