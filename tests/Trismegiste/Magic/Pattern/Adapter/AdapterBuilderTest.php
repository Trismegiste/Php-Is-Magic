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
        $this->contract = 'tests\Trismegiste\Magic\Pattern\Adapter\ToBeParsed';
        $this->builder = new AdapterBuilder($this->contract);
    }

    public function testTyping()
    {
        $newObj = $this->builder->getInstance(new \stdClass());
        $this->assertInstanceOf($this->contract, $newObj);
    }

    public function testClosure()
    {
        $adaptee = new \stdClass();
        $adaptee->data = 'kuchinawa';
        $newObj = $this->builder
                ->addMethod('getName', function() {
                            return $this->adaptee->data;
                        })
                ->getInstance($adaptee);
        $this->assertEquals('kuchinawa', $newObj->getName());
    }

}

interface ToBeParsed
{

    public function getName();
}