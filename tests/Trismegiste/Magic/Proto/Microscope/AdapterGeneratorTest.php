<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Microscope;

use Trismegiste\Magic\Proto\Microscope\AdapterGenerator;

/**
 * AdapterGeneratorTest tests the generator
 */
class AdapterGeneratorTest extends \PHPUnit_Framework_TestCase
{

    protected $generator;
    protected $wrapped;
    protected $adapterFqcn;

    protected function setUp()
    {
        $this->generator = new AdapterGenerator();
        $this->wrapped = $this->getMock(__NAMESPACE__ . '\TooBig');
        $this->adapterFqcn = __NAMESPACE__ . '\Adapter';
    }

    public function testGeneration()
    {
        $this->assertFalse(class_exists($this->adapterFqcn));
        $code = $this->generator->generate(
                new \ReflectionClass(__NAMESPACE__ . '\Reduced'), 'Adapter', new \ReflectionClass($this->wrapped)
        );

        eval($code);
        $this->assertTrue(class_exists($this->adapterFqcn));

        $this->wrapped->expects($this->once())
                ->method('proto');

        $arr = array();
        $fqcn = $this->adapterFqcn;
        $adapted = new $fqcn($this->wrapped);
        $adapted->proto($this->getMock('Iterator'), $arr, function() {
                    
                });
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNotMatched()
    {
        $fqcn = $this->adapterFqcn;
        $adapted = new $fqcn($this->wrapped);
        $adapted->noMatching();
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNoMatchingDueToReferencedArg()
    {
        $fqcn = $this->adapterFqcn;
        $adapted = new $fqcn($this->wrapped);
        $adapted->checkReference('dummy');
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNoMatchingDueToTypeArray()
    {
        $fqcn = $this->adapterFqcn;
        $adapted = new $fqcn($this->wrapped);
        $adapted->checkArray(array());
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNoMatchingDueToParamCount()
    {
        $fqcn = $this->adapterFqcn;
        $adapted = new $fqcn($this->wrapped);
        $adapted->checkNumber(73, 42);
    }

}