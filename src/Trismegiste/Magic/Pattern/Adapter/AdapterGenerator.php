<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Adapter;

/**
 * AdapterGenerator generates code based on an interface
 */
class AdapterGenerator
{

    public function generateAdapter(\ReflectionClass $refl, $adapterName, $injectionMethod = 'addAdaptedMethod')
    {
        if (!$refl->isInterface()) {
            throw new \LogicException($refl->getNamespaceName() . ' must be an interface');
        }

        $namespace = $refl->getNamespaceName();
        $shortName = $refl->getShortName();

        $body = ' protected $dynamicMethod;
            public function ' . $injectionMethod . '($name, \Closure $cls) { 
                $this->dynamicMethod[$name] = $cls; 
            }';

        foreach ($refl->getMethods() as $method) {
            if (!preg_match('#^__#', $method->getName())) {
                $body .= $this->generateMethodDeclaration($method);
            }
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
                throw new \BadMethodCallException('$name is not implemented');
            }
            return call_user_func_array(\$this->dynamicMethod['$name'], func_get_args()); 
                }";

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
            $output .= $param->getClass()->getName() . ' ';
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