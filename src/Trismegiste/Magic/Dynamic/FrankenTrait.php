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

        return $this;
    }

    protected function addTrait($fqcn)
    {
        $added = new \ReflectionClass($fqcn);
        if (!$added->isTrait()) {
            throw new \LogicException("$fqcn is not a trait");
        }
        $this->traitList[] = new \ReflectionClass($fqcn);

        return $this;
    }

    public function addPart($interfaceName, $traitName = null)
    {
        if (is_null($traitName)) {
            $traitName = $interfaceName . 'Impl';
        }
        $this->addInterface($interfaceName);
        $this->addTrait($traitName);

        return $this;
    }

    public function getInstance()
    {
        $args = func_get_args();

        $namespace = explode('\\', $this->monsterName);
        $shortName = array_pop($namespace);
        $namespace = implode('\\', $namespace);

        $generated = "namespace $namespace {\n";
        foreach ($this->interfaceList as $interf) {
            $generated .= "use " . $interf->name . ";\n";
        }
        foreach ($this->traitList as $tra) {
            $generated .= "use " . $tra->name . ";\n";
        }

        $generated .= "class $shortName implements ";
        $sep = '';
        foreach ($this->interfaceList as $interf) {
            $generated .= $sep . $interf->getShortname();
            $sep = ', ';
        }
        $generated .= " {\n  use ";
        $sep = '';
        foreach ($this->traitList as $tra) {
            $generated .= $sep . $tra->getShortname();
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