<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Adapter;

use Trismegiste\Magic\Pattern\Adapter\AdapterGenerator;

/**
 * AdapterGeneratorTest tests AdapterGenerator
 */
class AdapterGeneratorTest extends \PHPUnit_Framework_TestCase
{

    protected $contract;
    protected $generator;

    protected function setUp()
    {
        $this->contract = __NAMESPACE__ . '\ToBeParsed';
        $this->generator = new AdapterGenerator();
    }

    public function testOnInterface()
    {
        $dump = $this->generator->generateAdapter(new \ReflectionClass($this->contract), 'Noein');
        $this->assertRegExp('#class\s+Noein\s+implements\s+ToBeParsed#', $dump);
        $this->assertRegExp('#function getName\(\)#', $dump);
        $this->assertRegExp('#function withParam\(\\\\SplFixedArray#', $dump);
    }

}