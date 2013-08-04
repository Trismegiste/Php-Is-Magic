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
    private $generator;

    public function __construct()
    {
        $this->generator = new AdapterGenerator();
    }

    public function adapt($fqcn)
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

    public function getInstance()
    {
        $refl = new \ReflectionClass($this->interfaceName);
        $adapterName = $refl->getShortName() . 'Adapter_' . rand();

        $generated = $this->generator->generateAdapter($refl, $adapterName);

        eval($generated);
        $refl = new \ReflectionClass($refl->getNamespaceName() . '\\' . $adapterName);

        $adaptee = $refl->newInstance();
        foreach ($this->implementation as $name => $method) {
            $adaptee->addAdaptedMethod($name, \Closure::bind($method, $adaptee, $refl->getName()));
        }

        return $adaptee;
    }

}