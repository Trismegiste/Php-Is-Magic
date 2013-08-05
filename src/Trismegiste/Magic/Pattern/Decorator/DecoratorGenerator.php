<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Decorator;

/**
 * DecoratorGenerator generates code based on an interface
 */
class DecoratorGenerator
{

    protected $methodGen;

    public function __construct()
    {
        $this->methodGen = new MethodGenerator();
    }

    public function generate(\ReflectionClass $refl, $adapterName, $injectionMethod = 'addClosure')
    {
        if (!$refl->isInterface()) {
            throw new \LogicException($refl->getName() . ' must be an interface');
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
            $body .= $this->methodGen->generate($method);
        }

        return "namespace $namespace { class $adapterName implements $shortName { $body } }";
    }

}