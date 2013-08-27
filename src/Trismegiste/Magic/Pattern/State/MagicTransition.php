<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\State;

/**
 * MagicTransition is an implementation for interface ...
 */
trait MagicTransition
{

    public function __call($name, $args)
    {
        if (preg_match('#^do([A-Z].+)$#', $name, $extract)) {
            $this->doTransition(lcfirst($extract[1]));
        } else {
            trigger_error("Call to undefined method " . __CLASS__ . "::$name", E_USER_ERROR);
        }
    }

}