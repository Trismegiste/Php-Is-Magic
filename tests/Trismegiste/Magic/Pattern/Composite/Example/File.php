<?php

/*
 * Magic Pattern example
 */

namespace tests\Trismegiste\Magic\Pattern\Composite\Example;

use Trismegiste\Magic\Pattern\Composite\Leaf;

/**
 * File is a file in a folder
 */
class File implements Leaf, ModelInterface
{

    use ModelImpl;
}