<?php

/*
 * Magic patterns
 */

namespace tests\Trismegiste\Magic\Pattern\Composite;

/**
 * CompositeTest tests the composite
 */
class CompositeTest extends CompositeTestCase
{

    protected function buildChild()
    {
        return $this->getMock('Trismegiste\Magic\Pattern\Composite\Component');
    }

    protected function buildRootNode()
    {
        return $this->getObjectForTrait('Trismegiste\Magic\Pattern\Composite\CompositeImpl');
    }

}