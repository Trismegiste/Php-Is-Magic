<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Adapter;

use Trismegiste\Magic\Pattern\Adapter\AdapterBuilder;

/**
 * AdapterBuilderTest tests AdapterBuilder
 */
class AdapterBuilderTest extends \PHPUnit_Framework_TestCase
{

    protected $contract;
    protected $builder;

    protected function setUp()
    {
        $this->contract = __NAMESPACE__ . '\ToBeParsed';
        $this->builder = new AdapterBuilder();
    }

    public function testTyping()
    {
        $newObj = $this->builder
                ->adapt($this->contract)
                ->getInstance();
        $this->assertInstanceOf($this->contract, $newObj);
    }

    public function testClosure()
    {
        $adaptee = new \stdClass();
        $adaptee->data = 'kuchinawa';
        $newObj = $this->builder
                ->adapt($this->contract)
                ->addMethod('getName', function() use ($adaptee) {
                            return $adaptee->data;
                        })
                ->getInstance();
        $this->assertEquals('kuchinawa', $newObj->getName());
    }

    /**
     * @expectedException LogicException
     */
    public function testInterfaceOnly()
    {
        $this->builder
                ->adapt('\SplFixedArray')
                ->getInstance();
    }

    /**
     * @expectedException BadMethodCallException
     * @expectedExceptionMessage getName is not implemented
     */
    public function testNotImplemented()
    {
        $newObj = $this->builder
                ->adapt($this->contract)
                ->getInstance();
        $newObj->getName();
    }

}
