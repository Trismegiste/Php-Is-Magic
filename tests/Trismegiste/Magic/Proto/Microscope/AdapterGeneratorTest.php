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

    protected function createAdapted($obj)
    {
        $fqcn = $this->adapterFqcn;

        return new $fqcn($obj);
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
        $this->createAdapted($this->wrapped)
                ->proto($this->getMock('Iterator'), $arr, function() {
                            
                        });
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNotMatched()
    {
        $this->createAdapted($this->wrapped)->noMatching();
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNoMatchingDueToReferencedArg()
    {
        $this->createAdapted($this->wrapped)->checkReference('dummy');
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNoMatchingDueToTypeArray()
    {
        $this->createAdapted($this->wrapped)->checkArray(array());
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNoMatchingDueToParamCount()
    {
        $this->createAdapted($this->wrapped)->checkNumber(73, 42);
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage implemented
     */
    public function testNoMatchingDueToReturnedRef()
    {
        $this->createAdapted($this->wrapped)->checkReturnRef();
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage interface
     */
    public function testValidator()
    {
        $this->generator->generate(
                new \ReflectionClass('ArrayObject'), 'aaaa', new \ReflectionClass($this->wrapped)
        );
    }

}