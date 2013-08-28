<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\FactoryMethod;

use Trismegiste\Magic\Pattern\FactoryMethod\Generator;

/**
 * GeneratorTest tests the generator for factory method
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{

    protected $generator;

    protected function setUp()
    {
        $this->generator = new Generator();
    }

    public function testGenerate()
    {
        $this->assertFalse(interface_exists(__NAMESPACE__ . '\DummyFactory'));
        $factory = $this->generator->getFactory(__NAMESPACE__ . '\Dummy');
        $this->assertTrue(interface_exists(__NAMESPACE__ . '\DummyFactory'));
        $this->assertInstanceOf(__NAMESPACE__ . '\DummyFactory', $factory);
    }

    public function testFactory()
    {
        $factory = $this->generator->getFactory(__NAMESPACE__ . '\Dummy');
        $obj = $factory->create();
        $this->assertInstanceOf(__NAMESPACE__ . '\Dummy', $obj);
    }

    public function testReentering()
    {
        $factory1 = $this->generator->getFactory(__NAMESPACE__ . '\Dummy');
        $this->assertInstanceOf(__NAMESPACE__ . '\DummyFactory', $factory1);
        $factory2 = $this->generator->getFactory(__NAMESPACE__ . '\Dummy');
        $this->assertInstanceOf(__NAMESPACE__ . '\DummyFactory', $factory2);
        $this->assertEquals(get_class($factory1), get_class($factory2));
    }

}