<?php

/*
 * Magic PHP
 */

namespace tests\Trismegiste\Magic\Proto\AnemicModel;

use Trismegiste\Magic\Proto\AnemicModel\GetterSetter;

/**
 * GetterSetterTest tests GetterSetter trait
 */
class GetterSetterTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        $this->object = new Container();
    }

    public function testSetter()
    {
        $this->object->setAnswer(42);
        $this->assertAttributeEquals(42, 'answer', $this->object);
    }

    public function testGetter()
    {
        $this->object->setAnswer(42);
        $this->assertEquals(42, $this->object->getAnswer());
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testBadFormat()
    {
        $this->object->getunreadable();
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testIDontLikeUnderscore()
    {
        $this->object->getOld_underscore_is_old();
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Call to undefined method tests\Trismegiste\Magic\Proto\AnemicModel\Container::unknowMethod()
     */
    public function testFailedCall()
    {
        $this->object->unknowMethod(42);
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Property unknown is not defined
     */
    public function testUnknownProp()
    {
        $this->object->getUnknown();
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Property injection is not defined
     */
    public function testNotWorkingOnInjectedProperty()
    {
        $this->object->injection = 666;
        $this->object->getInjection();
    }

    public function testMotherPropInSubclass()
    {
        $obj = new Daughter();
        $obj->setAnswer(42);
        $this->assertEquals(42, $obj->getAnswer());
    }

    public function testSuperClassProp()
    {
        $this->object->setInherited(42);
        $this->assertEquals(42, $this->object->getInherited());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Property data is not defined
     */
    public function testDaughterPropInSubclass()
    {
        $obj = new Daughter();
        // throws exception : we don't want to inherit of magic behavior
        // GetterSetter (too risky and buggy)
        $obj->setData(666);
    }

    public function testPrivateProp()
    {
        $this->object->setNotInherited(73);
        $this->assertEquals(73, $this->object->getNotInherited());
    }

    public function testPrivatePropInSubclass()
    {
        $obj = new Daughter();
        // notInherited is private in Container but LSP dictates anyway
        // that public methods [g|s]etNotInherited should be accessed
        // in Daughter subclass. That's why the trait check properties on __CLASS__
        // and not get_called_class()
        $obj->setPrivate(777);
        $this->assertEquals(777, $obj->getNotInherited());
        $obj->setNotInherited(128);
        $this->assertEquals(128, $obj->getNotInherited());
        $this->assertEquals(128, $obj->getPrivate());
    }

}

class Root
{

    protected $inherited;

}

class Container extends Root
{

    use GetterSetter;

    protected $answer;
    private $notInherited;
    protected $old_underscore_is_old;

    public function getPrivate()
    {
        return $this->notInherited;
    }

    public function setPrivate($n)
    {
        $this->notInherited = $n;
    }

}

class Daughter extends Container
{

    protected $data;

}