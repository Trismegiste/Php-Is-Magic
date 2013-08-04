<?php

/*
 * Php is magic
 */

namespace tests\Trismegiste\Magic\Pattern\BiDirTree;

use tests\Trismegiste\Magic\Pattern\BiDirTree\Example\Folder;
use tests\Trismegiste\Magic\Pattern\BiDirTree\Example\File;

/**
 * CompositeTestCase is composite test case
 */
class CompositeTest extends \PHPUnit_Framework_TestCase
{

    protected $root;

    protected function setUp()
    {
        $this->root = $this->buildRootNode();
    }

    protected function buildRootNode()
    {
        return new Folder('root');
    }

    protected function buildChild()
    {
        return new File(rand());
    }

    protected function buildNode($level)
    {
        if ($level == 0) {
            $node = new File($level);
        } else {
            $node = new Folder($level);
            $node->append($this->buildNode($level - 1));
            $node->append($this->buildNode($level - 1));
        }
        return $node;
    }

    public function testEmpty()
    {
        $this->assertEquals(0, $this->root->count());
        $this->assertTrue($this->root->isOrphan());
        foreach ($this->root as $child) {
            $this->fail('No item to traverse');
        }
        $this->assertFalse($this->root->contains($this->buildChild()));
        $this->root->remove($this->buildChild());
    }

    public function testAddChild()
    {
        $child = $this->buildChild();
        $this->assertTrue($child->isOrphan());

        $this->root->append($child);
        $this->assertEquals(1, $this->root->count());
        foreach ($this->root as $item) {
            $this->assertEquals($child, $item);
        }
        $this->root->contains($child);
        $this->assertEquals($this->root, $child->getParent());
    }

    public function testNoDoubleAddChild()
    {
        $child = $this->buildChild();
        $this->root->append($child);
        $this->root->append($child);
        $this->assertEquals(1, $this->root->count());
        $this->assertEquals($this->root, $child->getParent());
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
            $this->assertEquals($this->root, $child->getParent());
        }
    }

    public function testChildrenSide()
    {
        $child = $this->buildChild();
        $this->assertTrue($child->isOrphan());

        $child->setParent($this->root);
        $this->assertEquals($this->root, $child->getParent());
        $this->assertFalse($child->isOrphan());
        $this->assertCount(1, $this->root->getIterator());
        $this->assertTrue($this->root->contains($child));

        $child->setOrphan();
        $this->assertTrue($child->isOrphan());
        $this->assertCount(0, $this->root->getIterator());
        $this->assertFalse($this->root->contains($child));
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
            $this->assertTrue($child->isOrphan());
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
            for ($k = 0; $k < 5; $k++) {
                $random = $children[($k + $j) % 5];
                $this->root->remove($random);
                $this->assertTrue($random->isOrphan());
            }
            $this->assertEquals(0, $this->root->count());
        }
    }

    public function testTree()
    {
        $depth = 4;
        $current = $this->buildNode($depth);

        // go down
        for ($k = 0; $k < $depth; $k++) {
            $current = $current->getIterator()->current();
        }
        $this->assertInstanceOf('tests\Trismegiste\Magic\Pattern\BiDirTree\Example\File', $current);

        // go up
        for ($k = 0; $k < $depth; $k++) {
            $current = $current->getParent();
        }
        $this->assertInstanceOf('tests\Trismegiste\Magic\Pattern\BiDirTree\Example\Folder', $current);
        $this->assertTrue($current->isOrphan());
    }

}