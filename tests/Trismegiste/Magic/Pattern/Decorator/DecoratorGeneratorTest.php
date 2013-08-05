<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\Decorator;

use Trismegiste\Magic\Pattern\Decorator\DecoratorGenerator;

/**
 * DecoratorGeneratorTest tests DecoratorGenerator
 */
class DecoratorGeneratorTest extends \PHPUnit_Framework_TestCase
{

    protected $contract;
    protected $generator;

    protected function setUp()
    {
        $this->contract = __NAMESPACE__ . '\ToBeParsed';
        $this->generator = new DecoratorGenerator();
    }

    public function testOnInterface()
    {
        $dump = $this->generator->generate(new \ReflectionClass($this->contract), 'HtmlDecorator');
        //   file_put_contents('dump.php',"<?php\n\n $dump");
        $this->assertRegExp('#class\s+HtmlDecorator\s+implements\s+ToBeParsed#', $dump);
        $this->assertRegExp('#function getName\(\)#', $dump);
        $this->assertRegExp('#function withParam\(\\\\SplFixedArray#', $dump);
    }
    
    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage stdClass must be
     */
    public function testValidator()
    {
        $this->generator->generate(new \ReflectionClass('\stdClass'), 'arf');
    }

}