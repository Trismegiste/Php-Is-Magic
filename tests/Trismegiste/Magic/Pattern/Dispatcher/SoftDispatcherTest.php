<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Dispatcher;

use Trismegiste\Magic\Pattern\Dispatcher\SoftDispatcher;

/**
 * SoftDispatcherTest tests the dispatcher
 */
class SoftDispatcherTest extends DispatcherTestCase
{

    public function testInvokationWithCollision()
    {
        $component1 = $this->getMock(__NAMESPACE__ . '\Component');
        $component2 = $this->getMock(__NAMESPACE__ . '\OtherComponent');
        $this->dispatcher->addListener($component1);
        $this->dispatcher->addListener($component2);

        $this->assertAttributeCount(2, 'listener', $this->dispatcher);

        $component1->expects($this->once())
                ->method('nameCollision')
                ->with($this->event);

        $component2->expects($this->once())
                ->method('nameCollision')
                ->with($this->event);

        $this->dispatcher->dispatch('nameCollision', $this->event);
    }

    public function testEventSubclass()
    {
        $colleague = $this->getMock(__NAMESPACE__ . '\UsingSubclass');
        $event = $this->getMock(__NAMESPACE__ . '\Extended');
        $this->dispatcher->addListener($colleague);

        $this->assertAttributeCount(1, 'listener', $this->dispatcher);

        $colleague->expects($this->once())
                ->method('useExtended')
                ->with($event);

        $this->dispatcher->dispatch('useExtended', $event);
    }

    protected function buildDispatcher()
    {
        return new SoftDispatcher();
    }

}