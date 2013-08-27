<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\State;

/**
 * MagicTransition add aliasing to method doTransition($name)
 * 
 * Example : doTransition('payment') could be invoked with doPayment()
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