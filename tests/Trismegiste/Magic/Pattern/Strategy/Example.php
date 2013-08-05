<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Strategy;

use Trismegiste\Magic\Pattern\Strategy\Context;
use Trismegiste\Magic\Pattern\Strategy\ContextImpl;

/**
 * Fixtures for tests
 */
class Example implements Context
{

    use ContextImpl;

    public function filter(array $lst)
    {
        $newList = array();
        foreach ($lst as $item) {
            if ($this->callStrategy($item)) {
                $newList[] = $item;
            }
        }

        return $newList;
    }

}