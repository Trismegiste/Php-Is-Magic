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

    protected function setUp()
    {
        $this->mediator = new MasterControl();
    }

    public function testRequest()
    {
        $emit = new Emitter($this->mediator);
        $recv = $this->getMock(__NAMESPACE__ . '\Receiver');
        $this->mediator
                ->export($emit, array())
                ->export($recv, array('handleRequest'));

        $recv->expects($this->once())
                ->method('handleRequest')
                ->will($this->returnValue(666));

        $this->assertEquals(666, $emit->execute());
    }

    /**
     * @expectedException \LogicException
     */
    public function testValidator1()
    {
        $this->mediator->export('coucou', array());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidator2()
    {
        $obj = new \stdClass();
        $this->mediator
                ->export($obj, array('duplicate'))
                ->export($obj, array('duplicate'));
    }

}