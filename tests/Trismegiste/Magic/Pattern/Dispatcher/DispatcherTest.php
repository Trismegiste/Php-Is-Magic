<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Dispatcher;

use Trismegiste\Magic\Pattern\Dispatcher\Dispatcher;

/**
 * DispatcherTest tests the dispatcher
 *
 * @author flo
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{

    protected $dispatcher;
    protected $event;

    protected function setUp()
    {
        $this->dispatcher = new Dispatcher();
        $this->event = $this->getMock('Trismegiste\Magic\Pattern\Dispatcher\Event');
    }

    public function testInvokation()
    {
        $component = $this->getMock(__NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component, __NAMESPACE__ . '\Component');

        $this->assertAttributeCount(2, 'listener', $this->dispatcher);

        $component->expects($this->once())
                ->method('doSomething')
                ->with($this->event);

        $component->expects($this->never())
                ->method('notListening2');

        $this->dispatcher->dispatch('doSomething', $this->event);
        $this->dispatcher->dispatch('notListening2', $this->event);
    }

    public function testInvokationWithCollision()
    {
        $component1 = $this->getMock(__NAMESPACE__ . '\Component');
        $component2 = $this->getMock(__NAMESPACE__ . '\OtherComponent');
        $this->dispatcher->addListener($component1, __NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component2, __NAMESPACE__ . '\OtherComponent');

        $this->assertAttributeCount(2, 'listener', $this->dispatcher);

        $component1->expects($this->once())
                ->method('nameCollision')
                ->with($this->event);

        $component2->expects($this->once())
                ->method('nameCollision')
                ->with($this->event);

        $this->dispatcher->dispatch('nameCollision', $this->event);
    }

    public function testSubclass()
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

    public function testMagicCall()
    {
        $component = $this->getMock(__NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component, __NAMESPACE__ . '\Component');

        $this->assertAttributeCount(2, 'listener', $this->dispatcher);

        $component->expects($this->once())
                ->method('doSomething')
                ->with($this->event);

        $this->dispatcher->dispatchDoSomething($this->event);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage undefined method
     */
    public function testMagicCallFailure()
    {
        $this->dispatcher->qdjqdjlsxlj();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage not an Event
     */
    public function testMagicCallWithBadParam()
    {
        $component = $this->getMock(__NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component, __NAMESPACE__ . '\Component');

        $this->dispatcher->dispatchDoSomething(new \stdClass());
    }

}