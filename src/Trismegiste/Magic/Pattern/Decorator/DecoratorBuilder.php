<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Decorator;

/**
 * DecoratorBuilder builds on-the-fly decorated object
 * 
 */
class DecoratorBuilder
{

    private $interfaceName;
    private $implementation = array();
    private $generator;

    public function __construct()
    {
        $this->generator = new DecoratorGenerator();
    }

    public function decorate($fqcn)
    {
        $this->interfaceName = $fqcn;
        $this->implementation = array();

        return $this;
    }

    public function addMethod($name, \Closure $meth)
    {
        $this->implementation[$name] = $meth;

        return $this;
    }

    public function getInstance($wrapped)
    {
        $refl = new \ReflectionClass($this->interfaceName);
        $adapterName = $refl->getShortName() . 'Decorator_' . rand();
        // this trick to prevent some "genius" to add closures after generation :
        $injectClosure = '_addDecoratedMethod_' . rand();

        $generated = $this->generator->generate($refl, $adapterName, $injectClosure);

        try {
            eval($generated);
            $refl = new \ReflectionClass($refl->getNamespaceName() . '\\' . $adapterName);
            $adaptee = $refl->newInstance($wrapped);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        foreach ($this->implementation as $name => $method) {
            call_user_func(array($adaptee, $injectClosure), $name, \Closure::bind($method, $adaptee, $refl->getName()));
        }

        return $adaptee;
    }

}