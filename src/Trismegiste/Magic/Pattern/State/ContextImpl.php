<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\State;

/**
 * ContextImpl implements ContextInterface and provides helpers to 
 * initialize state pattern
 */
trait ContextImpl
{

    protected $finiteStateMachine = array();
    protected $currentState = null;

    protected function addState($stateName, array $transition)
    {
        $this->finiteStateMachine[$stateName] = array();
        foreach ($transition as $transitionName => $action) {
            $closure = \Closure::bind($action, $this, __CLASS__);
            $this->finiteStateMachine[$stateName][$transitionName] = $closure;
        }

        if (is_null($this->currentState)) {
            $this->setState($stateName);
        }

        return $this;
    }

    protected function setState($name)
    {
        if (!array_key_exists($name, $this->finiteStateMachine)) {
            throw new \LogicException("$name is not a valid state");
        }

        $this->currentState = $name;
    }

    public function doTransition($tName)
    {
        if (array_key_exists($tName, $this->finiteStateMachine[$this->currentState])) {
            call_user_func($this->finiteStateMachine[$this->currentState][$tName]);
        }
    }

    public function getState()
    {
        return $this->currentState;
    }

}