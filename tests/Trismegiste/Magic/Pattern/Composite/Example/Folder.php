<?php

/*
 * Magic Pattern example
 */

namespace tests\Trismegiste\Magic\Pattern\Composite\Example;

use Trismegiste\Magic\Pattern\Composite\Composite;
use Trismegiste\Magic\Pattern\Composite\CompositeImpl;

/**
 * Folder is a folder with children
 */
class Folder implements Composite, ModelInterface
{

    use CompositeImpl,
        ModelImpl;
}