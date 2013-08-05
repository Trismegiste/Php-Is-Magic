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

    protected $methodGen;

    public function __construct()
    {
        $this->methodGen = new MethodGenerator();
    }

    public function generateAdapter(\ReflectionClass $refl, $adapterName, $injectionMethod = 'addAdaptedMethod')
    {
        if (!$refl->isInterface()) {
            throw new \LogicException($refl->getName() . ' must be an interface');
        }

        $namespace = $refl->getNamespaceName();
        $shortName = $refl->getShortName();

        $body = ' protected $dynamicMethod;
            public function ' . $injectionMethod . '($name, \Closure $cls) { 
                $this->dynamicMethod[$name] = $cls; 
            }';

        foreach ($refl->getMethods() as $method) {
            if (!preg_match('#^__#', $method->getName())) {
                $body .= $this->methodGen->generate($method);
            }
        }

        return "namespace $namespace { class $adapterName implements $shortName { $body } }";
    }

}