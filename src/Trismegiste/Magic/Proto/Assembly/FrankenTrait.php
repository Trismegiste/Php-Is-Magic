<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Proto\Assembly;

/**
 * FrankenTrait builds objects based on trait and interface
 */
class FrankenTrait implements Builder
{

    protected $interfaceList;
    protected $traitList;

    /**
     * Starts to build a new mixin
     * 
     * @return $this
     */
    public function start()
    {
        $this->interfaceList = array();
        $this->traitList = array();

        return $this;
    }

    protected function addInterface($fqcn)
    {
        $added = new \ReflectionClass($fqcn);
        if (!$added->isInterface()) {
            throw new \LogicException("$fqcn is not an interface");
        }
        $this->interfaceList[] = $added;
    }

    protected function addTrait($fqcn)
    {
        $added = new \ReflectionClass($fqcn);
        if (!$added->isTrait()) {
            throw new \LogicException("$fqcn is not a trait");
        }
        $this->traitList[] = new \ReflectionClass($fqcn);
    }

    /**
     * Adds an Interface with its associated Trait
     * 
     * @param string $interfaceName
     * @param string $traitName (default = interface fqcn suffixed with 'Impl')
     * 
     * @return $this
     */
    public function addPart($interfaceName, $traitName = null)
    {
        if (is_null($traitName)) {
            $traitName = $interfaceName . 'Impl';
        }
        $this->addInterface($interfaceName);
        $this->addTrait($traitName);

        return $this;
    }

    /**
     * Gets the result
     * 
     * @param mixed ... any number of arguments for the constructor
     * 
     * @return object
     * 
     * @throws \RuntimeException if generation failed
     */
    public function getInstance()
    {
        $args = func_get_args();

        $namespace = __NAMESPACE__;
        $shortName = 'Creature_' . spl_object_hash($this);
        $fqcn = $namespace . '\\' . $shortName;
        // generation
        if (!class_exists($fqcn)) {
            $generated = $this->generate($namespace, $shortName);
            try {
                eval($generated);
            } catch (\Exception $e) {
                throw new \RuntimeException('Failing at building ' . $e->getMessage());
            }
        }
        // instantiation
        $refl = new \ReflectionClass($fqcn);
        $monster = $refl->newInstanceArgs($args);

        return $monster;
    }

    protected function generate($namespace, $shortName)
    {
        $generated = "namespace $namespace {\n class $shortName implements ";
        $sep = '';
        foreach ($this->interfaceList as $interf) {
            $generated .= $sep . '\\' . $interf->getName();
            $sep = ', ';
        }
        $generated .= " {\n  use ";
        $sep = '';
        foreach ($this->traitList as $tra) {
            $generated .= $sep . '\\' . $tra->getName();
            $sep = ', ';
        }
        $generated .= ";\n}\n}";

        return $generated;
    }

}