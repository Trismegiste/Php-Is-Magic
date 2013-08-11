<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\CoR;

/**
 * ChainBuilder is a builder of CoR with closures
 */
class ChainBuilder
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

    public function append(\Closure $cls)
    {
        $newLink = new ClosureHandler($cls);

        if (is_null($this->chain)) {
            $this->chain = $newLink;
        } else {
            $this->chain->append($newLink);
        }

        return $this;
    }

    public function prepend(\Closure $cls)
    {
        $newLink = new ClosureHandler($cls);

        if (is_null($this->chain)) {
            $this->chain = $newLink;
        } else {
            $this->chain = $newLink->append($this->chain);
        }

        return $this;
    }

    public function getResult()
    {
        return $this->chain;
    }

}