<?php

/*
 * Magic Pattern example
 */

namespace tests\Trismegiste\Magic\Pattern\BiDirTree\Example;

use Trismegiste\Magic\Pattern\BiDirTree\Leaf;
use Trismegiste\Magic\Pattern\BiDirTree\LeafImpl;

/**
 * File is a file in a folder
 */
class File implements Leaf, ModelInterface
{

    use LeafImpl,
        ModelImpl;
}