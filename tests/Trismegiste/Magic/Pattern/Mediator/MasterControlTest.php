<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Mediator;

use Trismegiste\Magic\Pattern\Mediator\MasterControl;

/**
 * MasterControlTest tests MasterControl
 */
class MasterControlTest extends \PHPUnit_Framework_TestCase
{

    protected $mediator;
    protected $emitter;
    protected $receiver;

    protected function setUp()
    {
        $this->mediator = new MasterControl();
        $this->emitter = new Emitter($this->mediator);
        $this->receiver = $this->getMock(__NAMESPACE__ . '\Receiver');
    }

    public function testRequest()
    {
        $this->mediator
                ->export($this->emitter, array())
                ->export($this->receiver, array('handleRequest'));

        $this->receiver->expects($this->once())
                ->method('handleRequest')
                ->will($this->returnValue(666));

        $this->assertEquals(666, $this->emitter->execute());
    }

    public function testAliasing()
    {
        $this->mediator
                ->export($this->emitter, array())
                ->export($this->receiver, array('handle' => 'handleRequest'));

        $this->receiver->expects($this->once())
                ->method('handleRequest')
                ->will($this->returnValue(243));

        $this->assertEquals(243, $this->emitter->executeAlias());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage object
     */
    public function testValidatorObject()
    {
        $this->mediator->export('coucou', array());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage unknownMethod
     */
    public function testMethodExists()
    {
        $this->mediator->export($this->receiver, array('unknownMethod'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage already aliased
     */
    public function testValidatorCollision1()
    {
        $this->mediator
                ->export($this->receiver, array('handleRequest'))
                ->export($this->receiver, array('handleRequest'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage already aliased
     */
    public function testValidatorCollision2()
    {
        $obj = $this->getMockBuilder('Other')
                ->setMethods(array('something'))
                ->getMock();

        $this->mediator
                ->export($this->receiver, array('duplicate' => 'handleRequest'))
                ->export($obj, array('duplicate' => 'something'));
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testUnknown()
    {
        $this->mediator->something();
    }

}