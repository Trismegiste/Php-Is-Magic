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

    public function getParent();

    public function setParent(Composite $parent);

    public function setOrphan();

    public function isOrphan();
}

