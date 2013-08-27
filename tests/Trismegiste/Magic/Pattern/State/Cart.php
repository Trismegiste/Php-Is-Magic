<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\State;

use Trismegiste\Magic\Pattern\State;

/**
 * Cart is a fixture for test state
 */
class Cart implements State\Context
{

    use State\ContextImpl,
        State\MagicTransition;

    public function __construct()
    {
        $this->addState('basket', array(
                    'payment' => function() {
                        $this->setState('order');
                    },
                    'for_test' => function() {
                        $this->setState('basuhkasjk');
                    }
                ))
                ->addState('order', array(
                    'shipping' => function() {
                        $this->setState('shipped');
                    },
                    'cancel' => function() {
                        $this->setState('basket');
                    }
                ))
                ->addState('shipped', array(
                    'cancel' => function() {
                        throw new \LogicException();
                    },
                    'archive' => function() {
                        $this->setState('archived');
                    }
                ))
                ->addState('archived', array());
    }

}