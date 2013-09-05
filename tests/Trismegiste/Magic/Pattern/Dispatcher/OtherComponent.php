<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Dispatcher;

use Trismegiste\Magic\Pattern\Dispatcher\Event;

interface OtherComponent
{

    public function nameCollision(Event $e);
}