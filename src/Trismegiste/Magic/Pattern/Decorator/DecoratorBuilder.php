<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Decorator;

/**
 * DecoratorBuilder builds on-the-fly decorated object
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

    /**
     * Starts the building of a new decorator
     * 
     * @param string $fqcn FQCN of the interface
     * 
     * @return \Trismegiste\Magic\Pattern\Decorator\DecoratorBuilder this instance
     */
    public function decorate($fqcn)
    {
        $this->interfaceName = $fqcn;
        $this->implementation = array();

        return $this;
    }

    /**
     * Overrides an existing method
     * 
     * @param string $name method name
     * @param \Closure $meth implementation
     * 
     * @return \Trismegiste\Magic\Pattern\Decorator\DecoratorBuilder this instance
     */
    public function override($name, \Closure $meth)
    {
        $this->implementation[$name] = $meth;

        return $this;
    }

    /**
     * Gets the result
     * 
     * @param object $wrapped object that will be decorated
     * 
     * @return object the decorated object
     * 
     * @throws \RuntimeException if generation fails
     */
    public function getInstance($wrapped)
    {
        $refl = new \ReflectionClass($this->interfaceName);
        $decoratorName = $refl->getShortName() . 'Decorator_' . rand();
        // this trick to prevent some "genius" to add closures after generation :
        $injectClosure = '_addDecoratedMethod_' . rand();

        $generated = $this->generator->generate($refl, $decoratorName, $injectClosure);

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