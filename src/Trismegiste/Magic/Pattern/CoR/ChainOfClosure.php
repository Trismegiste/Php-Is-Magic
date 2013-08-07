<?php

/*
 * PhpIsMagic
 */

namespace Trismegiste\Magic\Pattern\CoR;

/**
 * ChainOfClosure is like a CoR but with closures
 */
class ChainOfClosure
{

    protected $chain = array();

    public function append(\Closure $cls)
    {
        $this->chain[] = $cls;

        return $this;
    }

    public function handle(Request $req)
    {
        $processed = false;

        foreach ($this->chain as $link) {
            $processed = call_user_func($link, $req);

            if ($processed) {
                return $processed;
            }
        }

        return false;
    }

}