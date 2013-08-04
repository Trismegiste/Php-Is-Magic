<?php

/*
 * Magic patterns
 */

namespace Trismegiste\Magic\Pattern\Composite;

/**
 * Composite is an interface for a node with children in a tree
 */
interface Composite extends Component, \IteratorAggregate, \Countable
{

    /**
     * append a child to this node
     * 
     * @param \Trismegiste\Magic\Pattern\Composite\Component $object
     */
    public function append(Component $object);

    /**
     * Remove a child from this node
     *  
     * @param \Trismegiste\Magic\Pattern\Composite\Component $object
     */
    public function remove(Component $object);

    /**
     * Is this node containing a child ?
     * 
     * @param \Trismegiste\Magic\Pattern\Composite\Component $object
     */
    public function contains(Component $object);
}

