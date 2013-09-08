<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Dispatcher;

use Trismegiste\Magic\Pattern\Dispatcher\StrongDispatcher;

/**
 * StrongDispatcherTest tests the StrongDispatcher
 */
class StrongDispatcherTest extends DispatcherTestCase
{

    public function testMultipleInvokation()
    {
        $component1 = $this->getMock(__NAMESPACE__ . '\Component');
        $component2 = $this->getMock(__NAMESPACE__ . '\Component');
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

    public function testComponentSubclass()
    {
        $colleague = $this->getMock(__NAMESPACE__ . '\SubComponent');
        $this->dispatcher->addListener($colleague);

        $this->assertAttributeCount(2, 'listener', $this->dispatcher);

        $colleague->expects($this->once())
                ->method('doSomething')
                ->with($this->event);

        $this->dispatcher->dispatch('doSomething', $this->event);
    }

    protected function buildDispatcher()
    {
        return new StrongDispatcher(__NAMESPACE__ . '\Component');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage not an interface
     */
    public function testBadConstructor()
    {
        new StrongDispatcher('stdClass');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage does not implement
     */
    public function testBadListener()
    {
        $this->dispatcher->addListener($this->getMock(__NAMESPACE__ . '\OtherComponent'));
    }

}