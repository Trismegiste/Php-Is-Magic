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
    protected $defaultInterface;

    public function __construct($fqin = null)
    {
        $this->defaultInterface = $fqin;
    }

    /**
     * Subscribe an object to all methods of an interface
     * 
     * @param object $listener
     * @param string $fqin fully gualified interface name
     */
    public function addListener($listener, $fqin = null)
    {
        if (is_null($fqin)) {
            $fqin = $this->defaultInterface;
            if (is_null($fqin)) {
                throw new \LogicException("No defined interface to listen to");
            }
        }

        if (!($listener instanceof $fqin)) {
            throw new \InvalidArgumentException(get_class($listener) . " does not implements $fqin");
        }

        $refl = new \ReflectionClass($fqin);
        foreach ($refl->getMethods() as $meth) {
            $methName = $meth->getName();
            if (!$meth->isStatic() && !preg_match('#^__.+#', $methName)) {
                $this->listener[$methName][] = $listener;
            }
        }
    }

    public function dispatch($methodName)
    {
        $param = func_get_args();
        array_shift($param);

        if (array_key_exists($methodName, $this->listener)) {
            foreach ($this->listener[$methodName] as $obj) {
                call_user_func_array(array($obj, $methodName), $param);
            }
        }
    }

}