<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Dynamic;

/**
 * FrankenTrait builds objects based on trait and interface
 */
class FrankenTrait
{

    protected $monsterName;
    protected $interfaceList;
    protected $traitList;

    /**
     * 
     * @param string $fqcn the name of the new class
     * 
     * @return $this
     */
    public function start($fqcn)
    {
        $this->monsterName = $fqcn;
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
     * @param string $traitName (default the interface name suffixed with 'Impl'
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
     * @return object
     * 
     * @throws \RuntimeException if generation failed
     */
    public function getInstance()
    {
        $args = func_get_args();

        $namespace = explode('\\', $this->monsterName);
        $shortName = array_pop($namespace);
        $namespace = implode('\\', $namespace);

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

        try {
            eval($generated);
            $refl = new \ReflectionClass($this->monsterName);
            $monster = $refl->newInstanceArgs($args);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failing at building ' . $e->getMessage());
        }

        return $monster;
    }

}