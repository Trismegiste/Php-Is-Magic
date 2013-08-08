<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\CoR;

/**
 * HandlerTest tests the Handler
 */
class HandlerTest extends \PHPUnit_Framework_TestCase
{

    protected $handler;

    protected function buildHandler()
    {
        return $this->getMockForAbstractClass('Trismegiste\Magic\Pattern\CoR\Handler');
    }

    public function testRecursiveAppend()
    {
        $chain = $this->buildHandler();
        $succ1 = $this->buildHandler();
        $succ2 = $this->buildHandler();

        $chain->append($succ1)->append($succ2);
        $this->assertAttributeEquals($succ2, 'successor', $succ1);
    }

}