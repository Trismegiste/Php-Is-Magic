<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Adapter;

use Trismegiste\Helper\MethodGenerator as TemplateGen;

/**
 * MethodGenerator generates a method for the interface
 */
class MethodGenerator extends TemplateGen
{

    protected function generateBody($name)
    {
        return "if (!isset(\$this->dynamicMethod['$name'])) {
                throw new \BadMethodCallException('$name is not implemented');
            }
            return call_user_func_array(\$this->dynamicMethod['$name'], func_get_args()); ";
    }

}