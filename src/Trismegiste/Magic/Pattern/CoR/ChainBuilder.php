<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\CoR;

/**
 * ChainBuilder is a builder of CoR with closures
 */
class ChainBuilder implements Factory
{

    protected $chain;

    /**
     * Start a new chain
     * 
     * @return self
     */
    public function start()
    {
        $this->chain = null;

        return $this;
    }

    /**
     * Appends a handler to the tail of the chain
     * 
     * @param \Closure $cls
     * 
     * @return self
     */
    public function append(\Closure $cls)
    {
        $newLink = $this->createHandler($cls);

        if (is_null($this->chain)) {
            $this->chain = $newLink;
        } else {
            $this->chain->append($newLink);
        }

        return $this;
    }

    /**
     * Prepends a handler to the head of the chain
     * 
     * @param \Closure $cls
     * 
     * @return self
     */
    public function prepend(\Closure $cls)
    {
        $newLink = $this->createHandler($cls);

        if (is_null($this->chain)) {
            $this->chain = $newLink;
        } else {
            $this->chain = $newLink->append($this->chain);
        }

        return $this;
    }

    /**
     * Builds a closure hanndler
     * 
     * @param \Closure $cls
     * 
     * @return \Trismegiste\Magic\Pattern\CoR\ClosureHandler
     */
    protected function createHandler(\Closure $cls)
    {
        return new ClosureHandler($cls);
    }

    /**
     * Gets the built chain
     * 
     * @return Hnndler
     */
    public function createChain()
    {
        return $this->chain;
    }

}