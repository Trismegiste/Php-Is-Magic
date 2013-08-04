<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Adapter;

/**
 * AdapterBuilder builds on-the-fly adapter
 * 
 */
class AdapterBuilder
{

    private $interfaceName;
    private $implementation = array();

    public function __construct($fqcn)
    {
        $this->interfaceName = $fqcn;
    }

    public function addMethod($name, \Closure $meth)
    {
        $this->implementation[$name] = $meth;

        return $this;
    }

    public function getInstance($object)
    {
        $refl = new \ReflectionClass($this->interfaceName);
        $adapterName = $refl->getShortName() . 'Adapter_' . rand();

        $generated = $this->generateAdapter($refl, $adapterName);

        eval($generated);
        $refl = new \ReflectionClass($refl->getNamespaceName() . '\\' . $adapterName);

        $adaptee = $refl->newInstance($object);
        foreach ($this->implementation as $name => $method) {
            $adaptee->addAdaptedMethod($name, \Closure::bind($method, $adaptee, $refl->getName()));
        }

        return $adaptee;
    }

    protected function generateAdapter(\ReflectionClass $refl, $adapterName)
    {
        $namespace = $refl->getNamespaceName();
        $shortName = $refl->getShortName();
        $body = ' protected $adaptee; 
            protected $dynamicMethod;
            public function __construct($obj) { $this->adaptee = $obj; } 
            public function addAdaptedMethod($name, \Closure $cls) { $this->dynamicMethod[$name] = $cls; }';
        foreach ($refl->getMethods() as $method) {
            if (!preg_match('#^__#', $method->getName())) {
                $body .= $this->generateMethodDelcaration($method);
            }
        }

        return "namespace $namespace { class $adapterName implements $shortName { $body } }";
    }

    protected function generateMethodDelcaration(\ReflectionMethod $method)
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
        $output .= ") { return call_user_func_array(\$this->dynamicMethod['$name'], func_get_args()); }";

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