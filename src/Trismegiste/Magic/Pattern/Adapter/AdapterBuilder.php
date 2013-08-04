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
        // this trick to prevent some "genius" to add closures after generation :
        $injectClosure = '_addAdaptedMethod_' . rand();

        $generated = $this->generator->generateAdapter($refl, $adapterName, $injectClosure);

        try {
            eval($generated);
            $refl = new \ReflectionClass($refl->getNamespaceName() . '\\' . $adapterName);
            $adaptee = $refl->newInstance();
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        foreach ($this->implementation as $name => $method) {
            call_user_func(array($adaptee, $injectClosure), $name, \Closure::bind($method, $adaptee, $refl->getName()));
        }

        return $adaptee;
    }

}