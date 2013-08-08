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

    protected function buildHandler($returnedValue = null)
    {
        $mock = $this->getMockForAbstractClass('Trismegiste\Magic\Pattern\CoR\Handler');
        if (!is_null($returnedValue)) {
            $mock->expects($this->once())
                    ->method('processing')
                    ->will($this->returnValue($returnedValue));
        }

        return $mock;
    }

    public function buildRequest()
    {
        return $this->getMock('Trismegiste\Magic\Pattern\CoR\Request');
    }

    public function testRecursiveAppend()
    {
        $chain = $this->buildHandler();
        $succ1 = $this->buildHandler();
        $succ2 = $this->buildHandler();

        $chain->append($succ1)->append($succ2);
        $this->assertAttributeEquals($succ1, 'successor', $chain);
        $this->assertAttributeEquals($succ2, 'successor', $succ1);
    }

    public function testCallProcessing()
    {
        $chain = $this->buildHandler(true);

        $request = $this->buildRequest();
        $ret = $chain->handle($request);
        $this->assertTrue($ret);
        $this->assertEquals(get_class($chain), $request->forDebugOnly);
    }

    public function testCallSuccessor()
    {
        $chain = $this->buildHandler(false);
        $succ = $this->buildHandler(true);

        $chain->append($succ);

        $request = $this->buildRequest();
        $ret = $chain->handle($request);
        $this->assertTrue($ret);
        $this->assertEquals(get_class($succ), $request->forDebugOnly);
    }

}