<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\BiDirTree;

/**
 * LeafImpl is an implementation for interface Leaf
 */
trait LeafImpl
{

    protected $parentNode = null;

    public function getParent()
    {
        return $this->parentNode;
    }

    public function setParent(Composite $parent)
    {
        $this->parentNode = $parent;
        if (!$parent->contains($this)) {
            $parent->append($this);
        }
    }

    public function isOrphan()
    {
        return is_null($this->parentNode);
    }

    public function setOrphan()
    {
        if (!is_null($this->parentNode) && ($this->parentNode->contains($this   ))) {
            $this->parentNode->remove($this);
        }
        $this->parentNode = null;
    }

}