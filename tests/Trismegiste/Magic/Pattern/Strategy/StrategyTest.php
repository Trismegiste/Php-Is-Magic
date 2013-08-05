<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Strategy;

/**
 * StrategyTest tests Strategy
 */
class StrategyTest extends \PHPUnit_Framework_TestCase
{

    protected $context;

    protected function setUp()
    {
        $this->context = new Example();
    }

    public function testUsing()
    {
        // only odd numbers :
        $this->context->setStrategy(function($a) {
                    return (bool) ($a % 2);
                });
        $this->assertCount(5, $this->context->filter(range(1, 10)));
        // only multiple of 3 :
        $this->context->setStrategy(function($a) {
                    return !(bool) ($a % 3);
                });
        $this->assertCount(3, $this->context->filter(range(1, 10)));
    }

    /**
     * @expectedException \LogicException
     */
    public function testStrategySet()
    {
        $this->context->filter(array(1));
    }

}