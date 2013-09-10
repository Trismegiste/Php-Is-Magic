<?php

/*
 * PhpIsMagic
 */

namespace tests\Trismegiste\Magic\Proto\Glue;

use Trismegiste\Magic\Proto\Glue\Glued;

class GlueExample
{

    use Glued;

    private $property;

    public function __construct($data)
    {
        $this->property = $data;
    }

}