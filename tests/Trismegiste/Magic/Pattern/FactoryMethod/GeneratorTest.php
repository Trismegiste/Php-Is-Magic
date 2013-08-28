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
        $this->generator->generate(__NAMESPACE__ . '\Dummy');
    }

}