<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Assembly;

use Trismegiste\Magic\Proto\Assembly\FrankenTrait;

/**
 * FrankenTraitTest tests FrankenTrait
 */
class FrankenTraitTest extends \PHPUnit_Framework_TestCase
{

    protected $doctor;

    protected function setUp()
    {
        $this->doctor = new FrankenTrait();
    }

    public function testMonster()
    {
        $monster = $this->doctor
                ->start()
                ->addPart(__NAMESPACE__ . '\Parts\Person')
                ->addPart(__NAMESPACE__ . '\Parts\TwoArmed')
                ->addPart(__NAMESPACE__ . '\Parts\TwoLegged')
                ->getInstance('Kiki');

        $this->assertEquals('Kiki', $monster->getName());

        $this->expectOutputString('I walk');
        $monster->walk();
    }

    public function testDifferentNaming()
    {
        $monster = $this->doctor
                ->start()
                ->addPart(__NAMESPACE__ . '\Parts\Person')
                ->addPart(__NAMESPACE__ . '\Parts\TwoLegged', __NAMESPACE__ . '\Parts\RobotLeggedTrait')
                ->getInstance('Kiki');

        $this->assertEquals('Kiki', $monster->getName());
    }

    /**
     * @expectedException ReflectionException
     */
    public function testValidatorUnknownTrait()
    {
        $monster = $this->doctor
                ->start()
                ->addPart('Iterator');
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage Iterator
     */
    public function testValidatorNotTrait()
    {
        $monster = $this->doctor
                ->start()
                ->addPart('Iterator', 'Iterator');
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage stdClass
     */
    public function testValidatorNotInterface()
    {
        $monster = $this->doctor
                ->start()
                ->addPart('stdClass');
    }

}