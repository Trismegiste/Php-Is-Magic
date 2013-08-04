<?php

/*
 * Php is magic
 */

namespace tests\Trismegiste\Magic\Pattern\Composite;

/**
 * CompositeTestCase is composite test case
 */
abstract class CompositeTestCase extends \PHPUnit_Framework_TestCase
{

    protected $root;

    protected function setUp()
    {
        $this->root = $this->buildRootNode();
    }

    abstract protected function buildRootNode();

    abstract protected function buildChild();

    public function testEmpty()
    {
        $this->assertEquals(0, $this->root->count());
        foreach ($this->root as $child) {
            $this->fail('No item to traverse');
        }
        $this->assertFalse($this->root->contains($this->buildChild()));
        $this->root->remove($this->buildChild());
    }

    public function testAddChild()
    {
        $child = $this->buildChild();
        $this->root->append($child);
        $this->assertEquals(1, $this->root->count());
        foreach ($this->root as $item) {
            $this->assertEquals($child, $item);
        }
        $this->root->contains($child);
    }

    public function testNoDoubleAddChild()
    {
        $child = $this->buildChild();
        $this->root->append($child);
        $this->root->append($child);
        $this->assertEquals(1, $this->root->count());
    }

    public function testMultipleAddChild()
    {
        for ($k = 0; $k < 10; $k++) {
            $this->root->append($this->buildChild());
        }
        $this->assertEquals(10, $this->root->count());
    }

    public function testMultipleContains()
    {
        $children = array();
        for ($k = 0; $k < 5; $k++) {
            $child = $this->buildChild();
            $children[] = $child;
            $this->root->append($child);
        }
        $this->assertEquals(5, $this->root->count());
        foreach ($children as $child) {
            $this->assertTrue($this->root->contains($child));
        }
    }

    public function testRemoving()
    {
        $children = array();
        for ($k = 0; $k < 5; $k++) {
            $child = $this->buildChild();
            $children[] = $child;
            $this->root->append($child);
        }
        foreach ($children as $child) {
            $this->root->remove($child);
        }
        $this->assertEquals(0, $this->root->count());
    }

    public function testRemovingRandomDuringIterator()
    {
        $children = array();
        for ($k = 0; $k < 5; $k++) {
            $child = $this->buildChild();
            $children[] = $child;
        }
        for ($j = 0; $j < 5; $j++) {
            foreach ($children as $child) {
                $this->root->append($child);
            }
            foreach ($children as $k => $child) {
                $this->root->remove($children[($k + $j) % 5]);
            }
            $this->assertEquals(0, $this->root->count());
        }
    }

}