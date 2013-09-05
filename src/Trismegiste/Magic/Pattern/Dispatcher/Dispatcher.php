<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\Dispatcher;

/**
 * Dispatcher is a dispatcher of event with closures and magic call
 */
class Dispatcher
{

    protected $listener = array();

    /**
     * Subscribe an object to all methods which can receive an Event
     * 
     * @param object $listener
     */
    public function addListener($listener)
    {
        $refl = new \ReflectionClass($listener);
        foreach ($refl->getMethods() as $meth) {
            $methName = $meth->getName();
            if (!$meth->isStatic() &&
                    !preg_match('#^__.+#', $methName) &&
                    $meth->getNumberOfParameters() == 1) {

                $classParam = $meth->getParameters()[0]->getClass();

                if (!is_null($classParam) &&
                        $classParam->implementsInterface(__NAMESPACE__ . '\Event')) {
                    $this->listener[$methName][] = $listener;
                }
            }
        }
    }

    public function dispatch($methodName, Event $event)
    {
        if (array_key_exists($methodName, $this->listener)) {
            foreach ($this->listener[$methodName] as $obj) {
                call_user_func(array($obj, $methodName), $event);
            }
        }
    }

}