<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\CoR;

use Trismegiste\Magic\Pattern\CoR\ChainOfClosure;
use Trismegiste\Magic\Pattern\CoR\Request;

/**
 * ChainnTest tests ChainOfClosure
 */
class ChainnTest extends \PHPUnit_Framework_TestCase
{

    protected $chain;
    protected $request;

    protected function setUp()
    {
        $this->chain = new ChainOfClosure();
        $this->request = $this->getMock('Trismegiste\Magic\Pattern\CoR\Request');
    }

    public function testEmpty()
    {
        $this->assertFalse($this->chain->handle($this->request));
    }

    public function testOneLink()
    {
        $this->chain->append(function(Request $req) {
                    return true;
                });
        $this->assertTrue($this->chain->handle($this->request));
    }

    public function testTwoLink()
    {
        $this->chain
                ->append(function(Request $req) {
                            $req->debug = 1;
                            return false;
                        })
                ->append(function(Request $req) {
                            $req->debug = 2;
                            return true;
                        });
        $this->assertEquals(2, $this->chain->handle($this->request));
    }

    public function testTwoLinkFirstOk()
    {
        $this->chain
                ->append(function(Request $req) {
                            $req->debug = 1;
                            return true;
                        })
                ->append(function(Request $req) {
                            $req->debug = 2;
                            return true;
                        });
        $this->assertEquals(1, $this->chain->handle($this->request));
    }

}