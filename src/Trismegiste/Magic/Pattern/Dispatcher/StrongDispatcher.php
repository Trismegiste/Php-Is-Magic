<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Dispatcher;

/**
 * StrongDispatcher is a dispatcher of event based on one interface
 */
class StrongDispatcher extends Dispatcher
{

    protected $contract;

    public function __construct($fqin)
    {
        $this->contract = new \ReflectionClass($fqin);
        
        if (!$this->contract->isInterface()) {
            throw new \InvalidArgumentException("$fqin is not an interface");
        }
    }

    /**
     * Subscribe an object wich implements the contract
     * 
     * @param object $listener
     */
    public function addListener($listener)
    {
        if (!$this->contract->isInstance($listener)) {
            throw new \InvalidArgumentException(get_class($listener) .
            ' does not implements ' .
            $this->contract->getName());
        }

        foreach ($this->contract->getMethods() as $meth) {
            $methName = $meth->getName();
            if ($meth->getNumberOfParameters() == 1) {
                // get type-hint
                $classParam = $meth->getParameters()[0]->getClass();
                // check type-hint
                if (!is_null($classParam) &&
                        $classParam->implementsInterface(__NAMESPACE__ . '\Event')) {
                    // subscribes
                    $this->listener[$methName][] = $listener;
                }
            }
        }
    }

}