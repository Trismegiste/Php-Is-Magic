<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Glue;

/**
 * GluedTest tests Glued
 */
class GluedTest extends \PHPUnit_Framework_TestCase
{

    public function testPrivateAccessInClosure()
    {
        $obj = new GlueExample(21);
        $obj->extract = function($mul) {
                    return $mul * $this->property;
                };

        $this->assertEquals(42, $obj->extract(2));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage undefined method
     */
    public function testBadMethodCall()
    {
        $obj = new GlueExample(21);
        $obj->sdfdsdsfdfs();
    }

    public function testPrivateAccessInSubclass()
    {
        $obj = new GlueSubclassed(21);
        $obj->extract = function($mul) {
                    return $mul * $this->property;
                };

        $this->assertEquals(42, $obj->extract(2));
    }

}