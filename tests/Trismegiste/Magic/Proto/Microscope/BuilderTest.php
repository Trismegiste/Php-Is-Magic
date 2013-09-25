<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Microscope;

use Trismegiste\Magic\Proto\Microscope\Builder;

/**
 * BuilderTest tests the builder
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{

    protected $builder;
    protected $wrapped;
    protected $adapterFqcn;

    protected function setUp()
    {
        $this->builder = new Builder();
        $this->wrapped = new TooBig();
        $this->adapterFqcn = __NAMESPACE__ . '\Reduced';
    }

    public function testWrapping()
    {
        $obj = $this->builder->scope($this->adapterFqcn)
                ->reduce($this->wrapped);
        $this->assertInstanceOf($this->adapterFqcn, $obj);
    }

    public function testWrappingSameParamSameClass()
    {
        $obj1 = $this->builder->scope($this->adapterFqcn)
                ->reduce($this->wrapped);
        $this->assertInstanceOf($this->adapterFqcn, $obj1);
        $obj2 = $this->builder->scope($this->adapterFqcn)
                ->reduce(new TooBig());
        $this->assertInstanceOf($this->adapterFqcn, $obj2);
        $this->assertEquals(get_class($obj1), get_class($obj2));
    }

}