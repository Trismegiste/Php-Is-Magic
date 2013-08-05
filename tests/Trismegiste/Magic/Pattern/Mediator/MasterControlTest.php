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
     */
    public function testValidatorObject()
    {
        $this->mediator->export('coucou', array());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidatorCollision1()
    {
        $obj = new \stdClass();
        $this->mediator
                ->export($obj, array('duplicate'))
                ->export($obj, array('duplicate'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidatorCollision2()
    {
        $obj = new \stdClass();
        $this->mediator
                ->export($obj, array('duplicate' => 'one'))
                ->export($obj, array('duplicate' => 'two'));
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testUnknown()
    {
        $this->mediator->something();
    }

}