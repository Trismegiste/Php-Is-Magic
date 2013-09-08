<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Dispatcher;

/**
 * SoftDispatcher is a dispatcher of event based on reflection
 */
class SoftDispatcher extends Dispatcher
{

    /**
     * Subscribe an object to all methods which can receive 
     * an Event (or a subclass of Event)
     * 
     * @param object $listener
     */
    public function addListener($listener)
    {
        $refl = new \ReflectionClass($listener);
        foreach ($refl->getMethods(\ReflectionMethod::IS_PUBLIC) as $meth) {
            $methName = $meth->getName();
            if (!$meth->isStatic() &&
                    !preg_match('#^__.+#', $methName) &&
                    $meth->getNumberOfParameters() == 1) {
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