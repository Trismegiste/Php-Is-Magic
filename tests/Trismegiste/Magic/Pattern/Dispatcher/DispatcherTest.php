<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Dispatcher;

use Trismegiste\Magic\Pattern\Dispatcher\Dispatcher;

/**
 * DispatcherTest is ...
 *
 * @author flo
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{

    protected $dispatcher;

    protected function setUp()
    {
        $this->dispatcher = new Dispatcher();
    }

    public function testInvokation()
    {
        $component = $this->getMock(__NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component, __NAMESPACE__ . '\Component');

        $component->expects($this->once())
                ->method('doSomething');

        $this->dispatcher->dispatch('doSomething');
    }

    public function testInvokationWithCollision()
    {
        $component1 = $this->getMock(__NAMESPACE__ . '\Component');
        $component2 = $this->getMock(__NAMESPACE__ . '\OtherComponent');
        $this->dispatcher->addListener($component1, __NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component2, __NAMESPACE__ . '\OtherComponent');

        $component1->expects($this->once())
                ->method('nameCollision');
        $component2->expects($this->once())
                ->method('nameCollision');

        $this->dispatcher->dispatch('nameCollision');
    }

}