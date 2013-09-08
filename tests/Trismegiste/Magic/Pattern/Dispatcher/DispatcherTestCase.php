<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Dispatcher;

/**
 * DispatcherTestCase is a template for testing dispatcher
 */
abstract class DispatcherTestCase extends \PHPUnit_Framework_TestCase
{

    protected $dispatcher;
    protected $event;

    abstract protected function buildDispatcher();

    protected function setUp()
    {
        $this->dispatcher = $this->buildDispatcher();
        $this->event = $this->getMock('Trismegiste\Magic\Pattern\Dispatcher\Event');
    }

    public function testInvokation()
    {
        $component = $this->getMock(__NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component);

        $this->assertAttributeCount(2, 'listener', $this->dispatcher);

        $component->expects($this->once())
                ->method('doSomething')
                ->with($this->event);

        $component->expects($this->never())
                ->method('notListening2');

        $this->dispatcher->dispatch('doSomething', $this->event);
        $this->dispatcher->dispatch('notListening2', $this->event);
    }

    public function testMagicCall()
    {
        $component = $this->getMock(__NAMESPACE__ . '\Component');
        $this->dispatcher->addListener($component);

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
        $this->dispatcher->addListener($component);

        $this->dispatcher->dispatchDoSomething(new \stdClass());
    }

}