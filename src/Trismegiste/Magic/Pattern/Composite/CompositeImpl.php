<?php

/*
 * Magic patterns
 */

namespace Trismegiste\Magic\Pattern\Composite;

/**
 * CompositeImpl is a trait that implements the Composite interface
 * 
 * I'm not using SplObjectStorage because of PHP bug 63917
 */
trait CompositeImpl
{

    private $children = array();

    public function count()
    {
        return count($this->children);
    }

    public function append(Component $object)
    {
        $this->children[spl_object_hash($object)] = $object;

        return $this;
    }

    public function remove(Component $object)
    {
        unset($this->children[spl_object_hash($object)]);

        return $this;
    }

    public function contains(Component $object)
    {
        return array_key_exists(spl_object_hash($object), $this->children);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->children);
    }

}

