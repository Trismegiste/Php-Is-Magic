<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Microscope;

use Trismegiste\Helper\MethodGenerator as TemplateGen;

/**
 * RedirectGenerator generates a adapted method for an interface
 */
class RedirectGenerator extends TemplateGen
{

    protected function generateBody($name)
    {
        return "return call_user_func_array(array(\$this->wrapped, '$name'), func_get_args());";
    }

}