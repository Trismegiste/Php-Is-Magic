<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Microscope;

/**
 * Builder builds on-the-fly an adapter based on an interface to 
 * narrow the scope of an object
 */
class Builder
{

    private $interfaceName;
    private $generator;

    public function __construct()
    {
        $this->generator = new AdapterGenerator();
    }

    /**
     * Starts the building of a new adapter based on an interface
     * 
     * @param string $fqcn FQCN of the interface
     * 
     * @return self for fluent interface
     */
    public function scope($fqcn)
    {
        $this->interfaceName = $fqcn;

        return $this;
    }

    /**
     * Gets the result
     * 
     * @param object $wrapped object that will be adapted
     * 
     * @return object the adapted object (aka adaptee)
     */
    public function reduce($wrapped)
    {
        $refl = new \ReflectionClass($this->interfaceName);
        $adapterName = $refl->getShortName() . 'Adapter_' . md5(get_class($wrapped));
        $adapterFqcn = $refl->getNamespaceName() . '\\' . $adapterName;

        if (!class_exists($adapterFqcn)) {
            $generated = $this->generator->generate($refl, $adapterName, new \ReflectionClass($wrapped));
            eval($generated);
        }

        $adapted = new \ReflectionClass($adapterFqcn);
        $decorated = $adapted->newInstance($wrapped);

        return $decorated;
    }

}