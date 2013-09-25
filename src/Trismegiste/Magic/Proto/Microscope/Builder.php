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
     * 
     * @throws \RuntimeException if generation fails
     */
    public function reduce($wrapped)
    {
        $refl = new \ReflectionClass($this->interfaceName);
        $decoratorName = $refl->getShortName() . 'Adapter_' . md5(get_class($wrapped));

        $generated = $this->generator->generate($refl, $decoratorName, new \ReflectionClass($wrapped));

        try {
            eval($generated);
            $refl = new \ReflectionClass($refl->getNamespaceName() . '\\' . $decoratorName);
            $decorated = $refl->newInstance($wrapped);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        foreach ($this->implementation as $name => $method) {
            call_user_func(array($decorated, $injectClosure), $name, \Closure::bind($method, $decorated, $refl->getName()));
        }

        return $decorated;
    }

}