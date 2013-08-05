<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Helper;

/**
 * MethodGenerator generates a public method based on reflection
 * 
 * Design pattern : Template Method
 */
abstract class MethodGenerator
{

    final public function generate(\ReflectionMethod $method)
    {
        $name = $method->getName();
        $output = ' public function ';
        if ($method->returnsReference()) {
            $output .= '&';
        }
        $output .= $method->getName() . '(';
        $separator = '';
        foreach ($method->getParameters() as $param) {
            $output .= $separator . $this->generateParameterDeclaration($param);
            $separator = ', ';
        }
        $output .= ") { " . $this->generateBody($name) . " }\n";

        return $output;
    }

    abstract protected function generateBody($name);

    protected function generateParameterDeclaration(\ReflectionParameter $param)
    {
        $output = '';
        if ($param->isArray()) {
            $output .= 'array ';
        } elseif (is_callable(array($param, 'isCallable')) && $param->isCallable()) {
            $output .= 'callable ';
        } elseif ($param->getClass()) {
            $output .= '\\' . $param->getClass()->getName() . ' ';
        }
        if ($param->isPassedByReference()) {
            $output .= '&';
        }
        $output .= '$' . $param->getName();
        if ($param->isDefaultValueAvailable()) {
            $output .= ' = ' . $param->getDefaultValue();
        }

        return $output;
    }

}