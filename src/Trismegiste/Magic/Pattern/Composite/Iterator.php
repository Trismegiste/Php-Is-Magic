<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Composite;

/**
 * Iterator is a recursive iterator Composite Pattern
 */
class Iterator implements \RecursiveIterator
{

    protected $branch;

    public function __construct(Composite $node)
    {
        $this->branch = $node->getIterator();
    }

    public function current()
    {
        return $this->branch->current();
    }

    public function getChildren()
    {
        if (!($this->hasChildren())) {
            throw new \RuntimeException('No child for this node');
        }

        return new self($this->branch->current());
    }

    public function hasChildren()
    {
        return $this->branch->current() instanceof Composite;
    }

    public function key()
    {
        return $this->branch->key();
    }

    public function next()
    {
        $this->branch->next();
    }

    public function rewind()
    {
        $this->branch->rewind();
    }

    public function valid()
    {
        return $this->branch->valid();
    }

}