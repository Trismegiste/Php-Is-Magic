<?php

/*
 * PHP is Magic
 */

namespace tests\Trismegiste\Magic\Pattern\Singleton;

use Trismegiste\Magic\Pattern\Singleton\Singleton;

/**
 * MagicTest tests the magic singleton
 */
class MagicTest extends \PHPUnit_Framework_TestCase
{

    public function testSubclassing()
    {
        //mother of singleton, it's standard
        $mother1 = Singleton::getInstance();
        $this->assertInstanceOf('Trismegiste\Magic\Pattern\Singleton\Singleton', $mother1);
        $mother2 = Singleton::getInstance();
        $this->assertSame($mother1, $mother2);
        // now the subclass
        $child1 = Child::getInstance();
        $this->assertInstanceOf(__NAMESPACE__ . '\Child', $child1);
        $child2 = Child::getInstance();
        $this->assertSame($child2, $child1);
        // check
        $this->assertNotEquals($mother1, $child1);
    }

}