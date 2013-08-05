<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Strategy;

use Trismegiste\Magic\Pattern\Strategy\Strategy;
use Trismegiste\Magic\Pattern\Strategy\StrategyImpl;

/**
 * Fixtures for tests
 */
class Example implements Strategy
{

    use StrategyImpl;

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