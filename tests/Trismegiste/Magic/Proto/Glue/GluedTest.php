<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Glue;

/**
 * GluedTest tests Glued trait
 */
class GluedTest extends \PHPUnit_Framework_TestCase
{

    public function testPrivateAccessInClosure()
    {
        $obj = new GlueExample(21);
        $obj->getAnswer = function($mul) {
                    return $mul * $this->property;
                };

        $this->assertEquals(42, $obj->getAnswer(2));
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
        $obj = new GlueSubclassed(666);
        $obj->extract = function($pu) {
                    // it's a choice to limit the scope of the bound closure
                    // to the dynamic type, like a standard method would do
                    // if declared in GlueSubclassed, regardless where
                    // the trait is used
                    $pu->assertFalse(property_exists($this, 'property'));
                };

        $obj->extract($this);
    }

    public function testSimplePropInjection()
    {
        $obj = new GlueExample(33);
        $obj->someData = 42;
        $this->assertEquals(42, $obj->someData);
    }

}