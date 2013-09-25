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
    }

}