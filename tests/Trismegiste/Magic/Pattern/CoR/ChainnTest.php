<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Pattern\CoR;

use Trismegiste\Magic\Pattern\CoR\ChainBuilder;
use Trismegiste\Magic\Pattern\CoR\Request;

/**
 * ChainnTest tests ChainOfClosure
 */
class ChainBuilderTest extends \PHPUnit_Framework_TestCase
{

    protected $builder;
    protected $request;

    protected function setUp()
    {
        $this->builder = new ChainBuilder();
        $this->request = $this->getMock('Trismegiste\Magic\Pattern\CoR\Request');
    }

    public function testOneLink()
    {
        $chain = $this->builder
                ->append(function(Request $req) {
                            return true;
                        })
                ->getResult();
        $this->assertTrue($chain->handle($this->request));
    }

    public function testTwoLink()
    {
        $chain = $this->builder
                ->append(function(Request $req) {
                            $req->debug = 1;
                            return false;
                        })
                ->append(function(Request $req) {
                            $req->debug = 2;
                            return true;
                        })
                ->getResult();
        $this->assertEquals(2, $chain->handle($this->request));
    }

    public function testTwoLinkFirstOk()
    {
        $chain = $this->builder
                ->prepend(function(Request $req) {
                            $req->debug = 2;
                            return true;
                        })
                ->prepend(function(Request $req) {
                            $req->debug = 1;
                            return true;
                        })
                ->getResult();
        $this->assertEquals(1, $chain->handle($this->request));
    }

}