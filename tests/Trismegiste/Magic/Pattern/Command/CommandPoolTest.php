<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Command;

use Trismegiste\Magic\Pattern\Command\CommandPool;

/**
 * CommandPoolTest tests CommandPool
 */
class CommandPoolTest extends \PHPUnit_Framework_TestCase
{

    protected $invoker;

    protected function setUp()
    {
        $this->invoker = new CommandPool();
        $this->invoker
                ->attach('Area', function($radius) {
                            return pi() * $radius * $radius;
                        })
                ->attach('Volume', function($radius, $height) {
                            return pi() * $radius * $radius * $height;
                        });
    }

    public function testArea()
    {
        $this->assertEquals(8171, $this->invoker->execute('Area', 51), 'mostly', 1);
    }

    public function testAreaWithMagic()
    {
        $this->assertEquals(8171, $this->invoker->execArea(51), 'mostly', 1);
    }

    public function testTwoParameter()
    {
        $this->assertEquals(25, $this->invoker->execVolume(2, 2), 'mostly', 1);
    }

    public function testWithReceiver()
    {
        $receiver = $this->getMock(__NAMESPACE__ . '\Receiver');
        $receiver->expects($this->exactly(2))
                ->method('mustBeCalled');

        $this->invoker->attach('WithReceiver', function() use ($receiver) {
                    $receiver->mustBeCalled();
                });

        $this->invoker->execute('WithReceiver');
        $this->invoker->execWithReceiver();
    }

}