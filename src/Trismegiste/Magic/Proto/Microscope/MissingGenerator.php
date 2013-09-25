<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Microscope;

use Trismegiste\Helper\MethodGenerator as TemplateGen;

/**
 * MissingGenerator generates a adapted method with matching
 */
class MissingGenerator extends TemplateGen
{

    protected function generateBody($name)
    {
        return "throw new \BadMethodCallException(__METHOD__ . ' is not implemented');";
    }

}