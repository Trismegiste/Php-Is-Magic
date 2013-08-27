<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\State;

/**
 * ContextTest tests the context for the state pattern
 */
class ContextTest extends \PHPUnit_Framework_TestCase
{

    protected $context;

    protected function setUp()
    {
        $this->context = new Cart();
    }

    public function provideWorkflow()
    {
        return array(
            array('order', 'payment'),
            array('basket', 'payment', 'cancel'),
            array('shipped', 'payment', 'shipping'),
            array('archived', 'payment', 'shipping', 'archive'),
            array('basket', 'mispell')
        );
    }

    /**
     * @dataProvider provideWorkflow
     */
    public function testTransition($resultState)
    {
        $transition = func_get_args();
        array_shift($transition);
        foreach ($transition as $action) {
            $this->context->doTransition($action);
        }
        $this->assertEquals($resultState, $this->context->getState());
    }

    public function testMagicAlias()
    {
        $this->assertEquals('basket', $this->context->getState());
        $this->context->doPayment();
        $this->assertEquals('order', $this->context->getState());
    }

}