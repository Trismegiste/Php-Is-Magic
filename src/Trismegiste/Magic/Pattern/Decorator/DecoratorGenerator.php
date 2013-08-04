<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Decorator;

/**
 * AdapterGenerator generates code based on an interface
 */
class DecoratorGenerator
{

    public function generate(\ReflectionClass $refl, $adapterName, $injectionMethod = 'addClosure')
    {
        if (!$refl->isInterface()) {
            throw new \LogicException($refl->getNamespaceName() . ' must be an interface');
        }

        $namespace = $refl->getNamespaceName();
        $shortName = $refl->getShortName();

        $body = ' protected $dynamicMethod;
            protected $wrapped;
            public function __construct(' . $shortName . ' $obj) { $this->wrapped = $obj; }
            public function ' . $injectionMethod . '($name, \Closure $cls) { 
                $this->dynamicMethod[$name] = $cls;
            }';

        foreach ($refl->getMethods() as $method) {
            $body .= $this->generateMethodDeclaration($method);
        }

        return "namespace $namespace { class $adapterName implements $shortName { $body } }";
    }

    protected function generateMethodDeclaration(\ReflectionMethod $method)
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
        $output .= ") { 
            if (!isset(\$this->dynamicMethod['$name'])) {
                return call_user_func_array(array(\$this->wrapped, '$name'), func_get_args()); 
            } else {
                return call_user_func_array(\$this->dynamicMethod['$name'], func_get_args()); 
            }
        }\n";

        return $output;
    }

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