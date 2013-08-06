<?php

/*
 * Magic patterns
 */

namespace Trismegiste\Magic\Pattern\BiDirTree;

/**
 * Component is an interface for all components of a bi-directional tree
 */
interface Component
{

    /**
     * Get parent node
     */
    public function getParent();

    /**
     * Set parent node and attach itself to the parent node
     * 
     * @param \Trismegiste\Magic\Pattern\BiDirTree\Composite $parent
     */
    public function setParent(Composite $parent);

    /**
     * Detach itself from the parent node
     */
    public function setOrphan();

    /**
     * Has this node a parent node ?
     * 
     * @return bool
     */
    public function isOrphan();
}

