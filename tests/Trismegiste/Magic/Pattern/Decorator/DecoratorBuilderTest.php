<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Decorator;

use Trismegiste\Magic\Pattern\Decorator\DecoratorBuilder;

/**
 * DecoratorBuilderTest tests DecoratorBuilder
 */
class DecoratorBuilderTest extends \PHPUnit_Framework_TestCase
{

    protected $builder;

    protected function setUp()
    {
        $this->builder = new DecoratorBuilder();
    }

    public function getArticle()
    {
        return array(array(new Article('Back to Shalla-bal')));
    }

    /**
     * @dataProvider getArticle
     */
    public function testWrapping(Model $obj)
    {
        $decorated = $this->builder
                ->decorate(__NAMESPACE__ . '\Model')
                ->getInstance($obj);
        $this->assertInstanceOf(__NAMESPACE__ . '\Model', $decorated);
        $this->assertEquals($obj->getTitle(), $decorated->getTitle());

        $decorated->setTitle('Ride');
        $this->assertEquals('Ride', $decorated->getTitle());
        $this->assertEquals('Ride', $obj->getTitle());

        $obj->setTitle('The Forgotten I');
        $this->assertEquals('The Forgotten I', $decorated->getTitle());
    }

    /**
     * @dataProvider getArticle
     */
    public function testDecoration(Model $obj)
    {
        $decorated = $this->builder
                ->decorate(__NAMESPACE__ . '\Model')
                ->override('getTitle', function() {
                            return '<h1>' . $this->wrapped->getTitle() . '</h1>';
                        })
                ->getInstance($obj);
        $this->assertEquals('<h1>Back to Shalla-bal</h1>', $decorated->getTitle());

        $decorated->setTitle('The Forgotten II');
        $this->assertEquals('<h1>The Forgotten II</h1>', $decorated->getTitle());
    }

}