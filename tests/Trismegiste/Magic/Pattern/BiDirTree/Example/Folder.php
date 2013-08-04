<?php

/*
 * Magic Pattern example
 */

namespace tests\Trismegiste\Magic\Pattern\BiDirTree\Example;

use Trismegiste\Magic\Pattern\BiDirTree\Composite;
use Trismegiste\Magic\Pattern\BiDirTree\CompositeImpl;

/**
 * Folder is a folder with children
 */
class Folder implements Composite, ModelInterface
{

    use CompositeImpl,
        ModelImpl;
}