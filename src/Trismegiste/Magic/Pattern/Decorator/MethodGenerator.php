<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Decorator;

use Trismegiste\Helper\MethodGenerator as TemplateGen;

/**
 * MethodGenerator generates a method for the interface
 */
class MethodGenerator extends TemplateGen
{

    protected function generateBody($name)
    {
        return " if (!isset(\$this->dynamicMethod['$name'])) {
                return call_user_func_array(array(\$this->wrapped, '$name'), func_get_args()); 
            } else {
                return call_user_func_array(\$this->dynamicMethod['$name'], func_get_args()); 
            } ";
    }

}