<?php

/*
 * PHP is Magic
 */

namespace Trismegiste\Magic\Proto\AnemicModel;

/**
 * GetterSetter is an implementation of automagic getters/setters
 * 
 * The purpose of this trait is to replace a container with public properties
 * by an anemic model with dumb accessor/mutator and ready to be subclassed
 * without generating future WTF.
 */
trait GetterSetter
{

    public function __call($methodName, $args)
    {
        if (preg_match('#^(get|set)([A-Z][A-Za-z0-9]*)$#', $methodName, $extract)) {

            $propName = lcfirst($extract[2]);

            // I freeze the scope to defined properties of the class where this trait is used 
            if (property_exists(__CLASS__, $propName)) {
                switch ($extract[1]) {
                    case 'set' :
                        $this->$propName = $args[0];
                        break;
                    case 'get' :
                        return $this->$propName;
                        break;
                }
            } else {
                throw new \BadMethodCallException("Property $propName is not defined in " . __CLASS__);
            }
        } else {
            throw new \BadMethodCallException("Method $methodName is unknown");
        }
    }

}