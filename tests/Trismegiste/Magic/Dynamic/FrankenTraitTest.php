<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Dynamic;

use Trismegiste\Magic\Dynamic\FrankenTrait;

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
                ->start("Castle\Creature")
                ->addPart(__NAMESPACE__ . '\Parts\Person')
                ->addPart(__NAMESPACE__ . '\Parts\TwoArmed')
                ->addPart(__NAMESPACE__ . '\Parts\TwoLegged')
                ->getInstance('Kiki');

        $this->assertEquals('Kiki', $monster->getName());
    }

}